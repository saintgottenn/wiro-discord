const { ECPairFactory } = require("ecpair");
const tinysecp256k1 = require("tiny-secp256k1");
const { networks, payments, Psbt } = require("bitcoinjs-lib");
const TronWeb = require("tronweb");

const axios = require("axios");
const mysql = require("mysql2/promise");
const express = require("express");

const app = express();
app.use(express.json());

const ECPair = ECPairFactory(tinysecp256k1);
const network = networks.bitcoin;

const dbConfig = {
    host: "127.0.0.1",
    user: "myapp",
    database: "myapp",
    password: "myapp",
    port: 52227,
};

function createBTCWallet() {
    const keyPair = ECPair.makeRandom({ network });
    const { address } = payments.p2wpkh({ pubkey: keyPair.publicKey, network });
    const privateKey = keyPair.toWIF();

    // Получите публичный ключ в формате Buffer и преобразуйте его в hex-строку
    const publicKey = keyPair.publicKey.toString("hex");

    return { address, privateKey, publicKey };
}

// {
//   address: 'bc1qjujprrd4e8e0g2tknd7d7e7vce6l9qj4nrl6f3',
//   privateKey: 'KzkvSmncHmXNvYzL2wQkHdzACZtLAxZT96gmSjnmJKV1jgDsj1HX',
//   publicKey: '028a32b31e4e492451a6a686a3311daf00677f4d14b73548e573515aac57e2ef69'
// }

async function sendBTC(adminPrivateKey, recipientAddress, amountToSend) {
    const keyPair = ECPair.fromWIF(adminPrivateKey, network);

    const adminAddress = payments.p2wpkh({
        pubkey: keyPair.publicKey,
        network,
    }).address;

    const unspentUrl = `https://api.blockcypher.com/v1/btc/main/addrs/${adminAddress}?unspentOnly=true`;
    const unspentResponse = await axios.get(unspentUrl);
    const unspentOutputs = unspentResponse.data.txrefs;

    if (!unspentOutputs || unspentOutputs.length === 0)
        throw new Error("No unspent outputs available");

    const numInputs = 1;
    const numOutputs = 2;

    const feeRate = 24; // Сатоши за байт, выберите актуальную ставку из рекомендуемых
    const estimatedTransactionSize = 10 + numInputs * 148 + numOutputs * 34;

    const fee = estimatedTransactionSize * feeRate;

    const inputTx = unspentOutputs[0];

    const totalInput = inputTx.value; // Общая сумма в сатоши, доступная из UTXO
    const sendingAmount = amountToSend - fee; // Сумма в сатоши, которую вы хотите отправить

    const change = totalInput - sendingAmount - fee;

    if (change < 0) {
        throw new Error("Недостаточно средств для отправки с учетом комиссии");
    }

    const previousTxHex = await fetchTransactionHex(inputTx.tx_hash);

    const psbt = new Psbt({ network: network })
        .addInput({
            hash: inputTx.tx_hash,
            index: inputTx.tx_output_n,
            nonWitnessUtxo: Buffer.from(previousTxHex, "hex"),
        })
        .addOutput({
            address: recipientAddress,
            value: sendingAmount, // Убедитесь, что это положительное число
        });

    // Добавьте выход для сдачи только если change > 0
    if (change > 0) {
        psbt.addOutput({
            address: adminAddress, // Адрес для сдачи
            value: change, // Сдача
        });
    }

    // Подписание транзакции
    psbt.signInput(0, keyPair);
    psbt.finalizeAllInputs();
    const transaction = psbt.extractTransaction().toHex();

    // Отправка подписанной транзакции через BlockCypher API для основной сети
    const blockCypherToken = "f9000031d7c9494183989822a7925503"; // Используйте свой токен API
    const url = `https://api.blockcypher.com/v1/btc/main/txs/push?token=${blockCypherToken}`;
    const data = { tx: transaction };
    const sendResponse = await axios.post(url, data);
    return sendResponse.data;
}

async function fetchTransactionHex(txHash) {
    const url = `https://api.blockcypher.com/v1/btc/main/txs/${txHash}?includeHex=true`;
    try {
        const response = await axios.get(url);
        const txHex = response.data.hex; // Получаем hex-строку транзакции

        return txHex;
    } catch (error) {
        console.error(`Error fetching transaction data: ${error}`);
        return null;
    }
}
async function isHashRegistered(hash) {
    const connection = await mysql.createConnection(dbConfig);
    try {
        const [rows] = await connection.execute(
            "SELECT * FROM deposits WHERE hash = ?",
            [hash]
        );
        return rows.length > 0;
    } catch (error) {
        console.error("Ошибка при проверке хэша в БД:", error);
        return false;
    } finally {
        await connection.end();
    }
}

async function checkBTCTransactions(address) {
    let transactionsData = [];
    try {
        const response = await axios.get(
            `https://blockchain.info/rawaddr/${address}`
        );
        const transactions = response.data.txs;

        if (transactions.length > 0) {
            for (const tx of transactions) {
                let incomingAmount = 0;
                let isIncomingTransaction = false;

                if (tx.out[0].addr === address) {
                    isIncomingTransaction = true;
                    incomingAmount += tx.out[0].value;
                }

                if (
                    !isIncomingTransaction ||
                    (await isHashRegistered(tx.hash))
                ) {
                    continue;
                }

                const usdValue = await convertCryptoToUSD(
                    "BTC",
                    incomingAmount / 100000000
                );
                if (usdValue) {
                    let connection;
                    try {
                        connection = await mysql.createConnection(dbConfig);
                        await connection.execute(
                            "INSERT INTO deposits (hash, amount) VALUES (?, ?)",
                            [tx.hash, usdValue.toString() + "$"]
                        );
                        transactionsData.push({
                            hash: tx.hash,
                            usdValue: usdValue.toString() + "$",
                            btc: incomingAmount,
                        });
                    } catch (error) {
                        console.error(
                            "Ошибка при добавлении транзакции в базу данных:",
                            error
                        );

                        return false;
                    } finally {
                        if (connection) {
                            await connection.end();
                        }
                    }
                }
            }
        }
    } catch (error) {
        console.error("Ошибка при проверке транзакций:", error);
        return false;
    }

    return transactionsData.length ? transactionsData : false;
}

const apiKey = "e45f34a5-c58d-459b-925f-cc2f1fb09f07";

const getCryptoPriceUSD = async (cryptoSymbol) => {
    const url = `https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest`;
    try {
        const response = await axios.get(url, {
            params: {
                symbol: cryptoSymbol,
                convert: "USD",
            },
            headers: {
                "X-CMC_PRO_API_KEY": apiKey,
            },
        });
        const data = response.data.data;
        const price = data[cryptoSymbol].quote.USD.price;

        return price;
    } catch (error) {
        console.error("Error getting crypto price:", error);
        return false;
    }
};

const convertCryptoToUSD = async (cryptoSymbol, amount) => {
    try {
        const price = await getCryptoPriceUSD(cryptoSymbol); // Получаем текущую цену криптовалюты
        if (price !== null) {
            const totalValue = amount * price; // Вычисляем общую стоимость в долларах

            return parseFloat(totalValue.toFixed(2));
        } else {
            return false;
        }
    } catch (error) {
        return false;
    }
};

async function getWalletByUniqueKey(uniqueKey) {
    let connection;
    try {
        connection = await mysql.createConnection(dbConfig);
        const [rows] = await connection.execute(
            "SELECT * FROM wallets WHERE unique_key = ?",
            [uniqueKey]
        );
        return rows[0]; // Возвращает первую запись или undefined, если кошелька нет
    } catch (error) {
        console.error("Ошибка при поиске кошелька:", error);
        throw error; // Выбрасывает ошибку дальше
    } finally {
        if (connection) {
            await connection.end();
        }
    }
}

const fullNode = new TronWeb.providers.HttpProvider("https://api.trongrid.io");
const solidityNode = new TronWeb.providers.HttpProvider(
    "https://api.trongrid.io"
);
const eventServer = new TronWeb.providers.HttpProvider(
    "https://api.trongrid.io"
);
const tronWeb = new TronWeb(fullNode, solidityNode, eventServer);

async function createTRONWallet() {
    try {
        const account = await tronWeb.createAccount();

        const privateKey = account.privateKey;
        const address = account.address.base58;

        return { address, privateKey };
    } catch (error) {
        console.error("Ошибка при создании кошелька:", error);
    }
}

async function checkTRONTransactions(address) {
    try {
        const url = `https://api.trongrid.io/v1/accounts/${address}/transactions/trc20?&contract_address=TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t&only_confirmed=true&limit=100`;
        const response = await axios.get(url);
        const transactions = response.data.data; // Получаем массив транзакций

        const incomingTransactions = await Promise.all(
            transactions
                .filter((tx) => tx.to === address && tx.type === "Transfer")
                .map(async (item) => {
                    let usdValue;

                    // Выполнение конвертации в USD
                    try {
                        usdValue = await convertCryptoToUSD(
                            "USDT",
                            item.value / 1000000
                        );
                    } catch (error) {
                        console.error("Error converting to USD:", error);
                        return null; // Или другое значение, указывающее на ошибку
                    }

                    // Возврат объекта с результатом конвертации
                    const finalTransaction = {
                        hash: item.transaction_id,
                        usdValue: usdValue + "$",
                        trx20: item.value,
                    };

                    if (await isHashRegistered(finalTransaction.hash)) {
                        return null;
                    }

                    let connection = await mysql.createConnection(dbConfig);

                    try {
                        await connection.execute(
                            "INSERT INTO deposits (hash, amount) VALUES (?, ?)",
                            [
                                finalTransaction.hash,
                                finalTransaction.usdValue.toString(),
                            ]
                        );
                    } catch (error) {
                        console.error("Error inserting into database:", error);
                        return null;
                    } finally {
                        await connection.end();
                    }

                    return finalTransaction;
                })
        );

        const transactionsData = incomingTransactions.filter(
            (tx) => tx !== null
        );

        return transactionsData.length ? transactionsData : false;
    } catch (error) {
        console.error("Ошибка при получении транзакций:", error);
    }
}

// {
//   address: 'TXmmjPNAhQDjgqnSZY8JyLroTvN6erErrK',
//   privateKey: '306349BC29B7C7F35D20777EADA584035F0C6A85B9DD28DECB32EE3E31AD7071'
// }

const Web3 = require("web3"); // Убедитесь, что библиотека Web3 установлена
const HttpProvider = require("web3-providers-http");

// Асинхронная функция для отправки токенов TRC20
async function sendTRC20(
    adminAddress,
    senderPrivateKey,
    senderAddress,
    amount
) {
    // Адрес контракта USDT в сети TRON
    const usdtContractAddress = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t";

    // Минимальный ABI для взаимодействия с контрактом
    const minABI = [
        // transfer
        {
            constant: false,
            inputs: [
                { name: "_to", type: "address" },
                { name: "_value", type: "uint256" },
            ],
            name: "transfer",
            outputs: [{ name: "", type: "bool" }],
            type: "function",
        },
        // decimals
        {
            constant: true,
            inputs: [],
            name: "decimals",
            outputs: [{ name: "", type: "uint8" }],
            type: "function",
        },
    ];

    try {
        // Инициализация Web3
        const web3 = new Web3(new HttpProvider("https://api.trongrid.io")); // Используйте провайдера TronGrid или другой узел TRON

        // Создание экземпляра контракта
        const contract = new web3.eth.Contract(minABI, usdtContractAddress);

        // Получение количества десятичных знаков токена
        const decimals = await contract.methods.decimals().call();

        // Конвертация количества токенов в соответствии с десятичными
        const tokenAmount = web3.utils
            .toBN(amount)
            .mul(web3.utils.toBN(10).pow(web3.utils.toBN(decimals)));

        // Добавление аккаунта отправителя в кошелек Web3
        const account = web3.eth.accounts.privateKeyToAccount(senderPrivateKey);
        web3.eth.accounts.wallet.add(account);

        // Выполнение транзакции
        const transaction = await contract.methods
            .transfer(adminAddress, tokenAmount)
            .send({
                from: senderAddress,
                gas: 100000, // Установите лимит газа
                gasPrice: "1000000000", // Установите цену газа (в wei)
            });

        // Вывод информации о транзакции
        console.log("Transaction receipt:", transaction);
    } catch (error) {
        // Обработка и вывод ошибок
        console.error("Error sending TRC20 token:", error);
    }
}

// Пример использования функции
sendTRC20(
    "АДРЕС_ПОЛУЧАТЕЛЯ",
    "ВАШ_ПРИВАТНЫЙ_КЛЮЧ",
    "ВАШ_АДРЕС_ОТПРАВИТЕЛЯ",
    "СУММА_ТОКЕНОВ"
);

app.post("/check-transactions", async (req, res) => {
    const { uniqueKey, currency, userId } = req.body; // Теперь мы ожидаем uniqueKey в теле запроса
    if (!uniqueKey) {
        return res.status(400).send("Unique key is required");
    }

    let wallet = await getWalletByUniqueKey(uniqueKey);

    if (currency === "BTC") {
        try {
            if (!wallet) {
                const newWallet = createBTCWallet();

                let connection = await mysql.createConnection(dbConfig);

                await connection.execute(
                    "INSERT INTO wallets (user_id, unique_key, address, private_wif) VALUES (?, ?, ?, ?)",
                    [userId, uniqueKey, newWallet.address, newWallet.privateKey]
                );

                await connection.end();
                wallet = newWallet;
            }

            const transactionsData = await checkBTCTransactions(wallet.address);

            if (transactionsData) {
                for (const trx of transactionsData) {
                    sendBTC(
                        wallet.private_wif,
                        "bc1qkfcxze7ng5gkzfl82hkged68mnnv9k4w992tfg",
                        trx.btc
                    )
                        .then((result) =>
                            console.log("Transaction broadcasted:", result)
                        )
                        .catch((error) => console.error("Error:", error));
                }
            }

            res.json(
                transactionsData.length ? transactionsData : transactionsData
            );
        } catch (error) {
            console.log(error);
            res.status(500).send("Internal Server Error");
        }
    }

    if (currency === "USDT") {
        try {
            if (!wallet) {
                let newWallet;

                createTRONWallet().then((res) => {
                    newWallet = res;
                });

                let connection = await mysql.createConnection(dbConfig);

                await connection.execute(
                    "INSERT INTO wallets (user_id, unique_key, address, private_wif) VALUES (?, ?, ?, ?)",
                    [userId, uniqueKey, newWallet.address, newWallet.privateKey]
                );

                await connection.end();

                wallet = newWallet;
            }
            const transactionsData = await checkTRONTransactions(
                wallet.address
            );

            if (transactionsData.length) {
                for (const trx of transactionsData) {
                    sendTRON(
                        "TGoptfXR7vU6biVuNcDsA639khFe99EC8B",
                        wallet.private_wif,
                        wallet.address,
                        trx.trx20
                    )
                        .then((result) =>
                            console.log("Transaction broadcasted:", result)
                        )
                        .catch((error) => console.error("Error:", error));
                }
            }

            res.json(
                transactionsData.length ? transactionsData : transactionsData
            );
        } catch (error) {
            console.log(error);
            res.status(500).send("Internal Server Error");
        }
    }
});

app.post("/exchange", async (req, res) => {
    const { currency } = req.body;

    try {
        let usdValue;

        if (currency.toUpperCase() !== "USDT") {
            usdValue = await convertCryptoToUSD(currency.toUpperCase(), 1);
        } else {
            usdValue = 1;
        }

        res.json(usdValue);
    } catch (error) {
        res.status(500).send("Internal Server Error");
    }
});

app.listen(3010, () => {
    console.log(`Server is running on port 3010...`);
});
