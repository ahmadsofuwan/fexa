<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Models\UserWidrawDoge;
use App\Models\UserWidrawUsdt;
use App\Models\UserWitdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Witdraw extends Controller
{
    public function index()
    {
        $witdraw = UserWitdraw::with('users')
            ->get();


        $data = [
            'nav' => 'WD',
            'witdraws' =>  $witdraw,
        ];
        return view('admin.witdraw', $data);
    }
    public function usdt()
    {
        $witdraw = UserWidrawUsdt::with('users')
            ->get();


        $data = [
            'nav' => 'WD USDT',
            'witdraws' =>  $witdraw,
        ];
        return view('admin.witdrawusdt', $data);
    }
    public function doge()
    {
        $witdraw = UserWidrawDoge::with('users')->get();


        $data = [
            'nav' => 'WD DOGE',
            'witdraws' =>  $witdraw,
        ];
        return view('admin.witdrawdoge', $data);
    }

    public function reject($id)
    {
        $id = Crypt::decrypt($id);
        $witdraw = UserWitdraw::find($id);



        if (empty($witdraw)) {
            Alert::error('sorry', 'data invalid');
            return back();
        }

        User::where('id', $witdraw->reff)->increment('saldo', $witdraw->saldo);

        $log = new Log;
        $log->reff = $witdraw->reff;
        $log->target = $witdraw->reff;
        $log->value = '+' . $witdraw->saldo;
        $log->note = 'Reject Withdraw';
        $log->save();

        $witdraw->status = 'reject';
        $witdraw->save();

        Alert::success('Success', 'successfully reject withdraw');
        return back();
    }
    public function accept($id)
    {
        $id = Crypt::decrypt($id);
        $witdraw = UserWitdraw::find($id);

        $log = new Log;
        $log->reff = $witdraw->reff;
        $log->target = $witdraw->reff;
        $log->value = '-' . $witdraw->saldo;
        $log->note = 'Accept Withdraw';
        $log->save();

        $witdraw->status = 'accept';
        $witdraw->save();

        Alert::success('Success', 'successfully accept withdraw');
        return back();
    }

    public function rejectUsdt($id)
    {
        $id = Crypt::decrypt($id);
        $witdraw = UserWidrawUsdt::find($id);

        if (empty($witdraw)) {
            Alert::error('sorry', 'data invalid');
            return back();
        }

        User::where('id', $witdraw->reff)->increment('usdt', $witdraw->saldo);



        $log = new Log;
        $log->reff = $witdraw->reff;
        $log->target = $witdraw->reff;
        $log->value = '+' . $witdraw->saldo;
        $log->note = 'Reject Withdraw';
        $log->save();

        $witdraw->status = "reject";
        $witdraw->save();

        Alert::success('Success', 'successfully reject withdraw');
        return back();
    }
    public function rejectDoge($id)
    {
        $id = Crypt::decrypt($id);
        $witdraw = UserWidrawDoge::find($id);

        if (empty($witdraw)) {
            Alert::error('sorry', 'data invalid');
            return back();
        }

        User::where('id', $witdraw->reff)->increment('doge', $witdraw->saldo);



        $log = new Log;
        $log->reff = $witdraw->reff;
        $log->target = $witdraw->reff;
        $log->value = '+' . $witdraw->saldo;
        $log->note = 'Reject Withdraw';
        $log->save();

        $witdraw->status = "reject";
        $witdraw->save();

        Alert::success('Success', 'successfully reject withdraw');
        return back();
    }
    public function acceptUsdt($id)
    {
        $id = Crypt::decrypt($id);
        $witdraw = UserWidrawUsdt::find($id);

        $log = new Log;
        $log->reff = $witdraw->reff;
        $log->target = $witdraw->reff;
        $log->value = '-' . $witdraw->saldo;
        $log->note = 'Accept Withdraw USDT';
        $log->save();

        $witdraw->status = 'accept';
        $witdraw->save();

        Alert::success('Success', 'successfully accept withdraw');
        return back();
    }
    public function acceptDoge($id)
    {
        $id = Crypt::decrypt($id);
        $witdraw = UserWidrawDoge::find($id);

        $log = new Log;
        $log->reff = $witdraw->reff;
        $log->target = $witdraw->reff;
        $log->value = '-' . $witdraw->saldo;
        $log->note = 'Accept Withdraw DOGE';
        $log->save();

        $witdraw->status = 'accept';
        $witdraw->save();

        Alert::success('Success', 'successfully accept withdraw');
        return back();
    }
}
