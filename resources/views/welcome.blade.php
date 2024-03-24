<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Подключите Socket.io, используемый Laravel Echo -->
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <!-- Подключите Laravel Echo -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.min.js"></script>
    </head>
    <body class="antialiased">
        adsds
              <ul id="chat">
        <!-- Сообщения будут добавляться сюда -->
    </ul>
    <script>
        const echo = new Echo({
            broadcaster: 'socket.io',
            host: 'http://127.0.0.1:6001/',
            auth: {
            headers: {
                Authorization: 'Bearer ' + "3|qmDDy6jxrcoaCumvR30bbQxN7n0riV70R8JMEBMo140c99f1",
                // Для SPA может не потребоваться
                },
            },
            // Для SPA:
            withCredentials: true,
        });

        
        // Подписываемся на канал и прослушиваем событие
        echo.private('tickets-chat.1') // Убедитесь, что это имя канала совпадает с тем, что вы используете на сервере
            .listen('.TicketMessageSent', (e) => {
                console.log(e); // Логируем в консоль для отладки
            });
    </script>
    </body>
</html>
