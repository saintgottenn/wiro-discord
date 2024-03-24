<?php

namespace App\Http\Controllers\Voyager;

use App\Models\BankLog;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function getOffers()
    {
        $offers = ProductLog::latest()->paginate(50);

        return view('voyager::product-logs.index', compact('offers'));
    }

    public function editOffer(Request $request, $id) 
    {
        $offer = ProductLog::findOrFail($id);

        return view('voyager::product-logs.edit', compact('offer'));
    }

    public function updateOffer(Request $request, $id) 
    {
        $offer = ProductLog::findOrFail($id);

        $offer->amount = $request->amount;
        $offer->country = $request->country;
        $offer->save();

        return view('voyager::product-logs.edit', compact('offer'));
    }

    public function destroyOffer(Request $request, $id) 
    {
        $offer = ProductLog::findOrFail($id);
        $offer->delete();

        return redirect()->route('admin.product-logs.index');
    }

    public function searchOffer(Request $request)
    {
        $searchTerm = $request->input('id');
        
        if (!empty($searchTerm)) {
            $offer = ProductLog::find($searchTerm);

            if ($offer) {
                return redirect()->route('admin.product-logs.edit', $offer->id);
            }

            return back()->with('error', 'Пользователь не найден');
        }

        return back();
    }


    public function getBanks()
    {
        $banks = BankLog::latest()->paginate(50);

        return view('voyager::banks.index', compact('banks'));
    }

    public function editBank(Request $request, $id) 
    {
        $bank = BankLog::findOrFail($id);

        return view('voyager::banks.edit', compact('bank'));
    }

    public function updateBank(Request $request, $id) 
    {
        $bank = BankLog::findOrFail($id);

        $bank->amount = $request->amount;
        $bank->balance = $request->balance;
        $bank->bank_link = $request->bank_link;
        $bank->save();

        return view('voyager::banks.edit', compact('bank'));
    }

    public function destroyBank(Request $request, $id) 
    {
        $bank = BankLog::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.banks.index');
    }

    public function searchBank(Request $request)
    {
        $searchTerm = $request->input('id');
        
        if (!empty($searchTerm)) {
            $offer = BankLog::find($searchTerm);

            if ($offer) {
                return redirect()->route('admin.banks.edit', $offer->id);
            }

            return back()->with('error', 'Пользователь не найден');
        }

        return back();
    }
}
