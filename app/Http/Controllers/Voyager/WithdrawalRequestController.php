<?php

namespace App\Http\Controllers\Voyager;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawalRequestController extends Controller
{
    public function index()
    {
        $wds = Withdrawal::latest()->paginate(50);

        return view('voyager::wds.index', compact('wds'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('id');
        
        if (!empty($searchTerm)) {
            $userByName = User::where('name', 'like', '%' . $searchTerm . '%')->orWhere('id', $searchTerm)->first();
            // dd($userByName);
            if ($userByName) {
                $wds = Withdrawal::where('user_id', $userByName->id)->paginate(50);
                dd($wds);
                return view('voyager::wds.index', compact('wds'));
            }

        }

        return redirect()->route('admin.withdrawals.index');
    }

    public function approve(Request $request, $id)
    {
        $wd = Withdrawal::findOrFail($id);
        $wd->transaction->status = 'Successfully';
        $wd->transaction->save();

        return back();
    }

    public function reject(Request $request, $id)
    {
        $wd = Withdrawal::findOrFail($id);
        $wd->transaction->status = 'Reject';
        $wd->transaction->save();

        return back();
    }
}
