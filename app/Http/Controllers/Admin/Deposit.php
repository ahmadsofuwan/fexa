<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Models\UserDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Deposit extends Controller
{
    public function index()
    {
        $deposit = UserDeposit::with('users')
            ->get();
        // dd($deposit->toArray());


        $data = [
            'nav' => 'Deposit',
            'deposits' =>  $deposit,
            'priceCoin' =>  $this->priceCoin,
        ];

        return view('admin.deposit', $data);
    }
    public function reject($id)
    {

        $id = Crypt::decrypt($id);
        $userDeposit = UserDeposit::find($id)->with('users')->first();
        UserDeposit::where('id', $id)->update(['status' => 'reject']);

        $log = new Log;
        $log->reff = $userDeposit->users->id;
        $log->target = $userDeposit->users->id;
        $log->value = '0';
        $log->note = 'reject Deposit';
        $log->save();

        Alert::success('Success', 'Success to reject');
        return back();
    }
    public function accept(Request $request)
    {
        $userDeposit = UserDeposit::with('users')
            ->find($request->id);
        User::find($userDeposit->users->id)->increment('doge', $request->saldo);


        $log = new Log;
        $log->reff = $userDeposit->users->id;
        $log->target = $userDeposit->users->id;
        $log->value = '+' . $request->saldo;
        $log->note = 'Deposit';
        $log->save();


        $userDeposit->status = 'accept';
        $userDeposit->save();
        Alert::success('Succes', 'Success to Deposit');
        return back();
    }
}
