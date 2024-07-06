<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Logstaking;
use App\Models\User;
use App\Models\UserDeposit;
use App\Models\UserWidrawDoge;
use App\Models\UserWidrawUsdt;
use App\Models\UserWitdraw;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class Wallet extends Controller
{
    public $priceCoin;

    public function __construct()
    {
        $this->priceCoin =  1 / floatval(env("PRICE_COIN", 0.0005));
    }

    public function index()
    {
        $xwdoge = xwdoge_price();
        $dogestar = Fexa_price();


        $total = Auth::user()->usdt;
        $total += Auth::user()->doge * doge_price();
        $total += Auth::user()->saldo * $xwdoge;
        if (Auth::user()->status == 'active') {
            $total += 100000 * $xwdoge;
        }



        $data = [
            'users' => Auth::user(),
            'total' => $total,
            'Fexa' => $dogestar,
            'user' => Auth::user(),
        ];

        return view('customer.wallet', $data);
    }
    public function transfer(Request $request)
    {

        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['error' => 'wrong password'], 400);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['error' => 'wrong password'], 400);
            }
        }

        switch ($request->type) {
            case 'dogestar':
                $fee = 1;
                $wallet = User::where('wallet', $request->wallet)->first();
                if (empty($wallet)) {
                    return response()->json(['error' => 'wallet not found ' . $request->wallet], 400);
                }
                if (Auth::user()->saldo < $request->amount) {
                    return response()->json(['error' => 'insufficient Dogestar'], 400);
                }
                if (Auth::user()->doge < $fee) {
                    return response()->json(['error' => 'insufficient Doge'], 400);
                }

                if ($request->amount < 0) {
                    return response()->json(['error' => 'amount cannot be less than 0'], 400);
                }

                $wallet->saldo += $request->amount;
                $wallet->save();

                Auth::user()->saldo -= $request->amount;
                Auth::user()->doge -= $fee;
                Auth::user()->save();

                //log user transfer
                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = $wallet->id;
                $log->value = '-' . $fee;
                $log->note = 'Gas Fee Doge';
                $log->save();

                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = $wallet->id;
                $log->value = '-' . $request->amount;
                $log->note = 'Tranfer Dogestar';
                $log->save();

                //log user transfer reciver
                $log = new Log;
                $log->reff =  $wallet->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $request->amount;
                $log->note = 'Tranfer Dogestar';
                $log->save();
                return response()->json(['success' => 'success transfered ']);
                break;
            case 'usdt':
                $fee = 1;
                $wallet = User::where('wallet', $request->wallet)->first();
                if (empty($wallet)) {
                    return response()->json(['error' => 'wallet not found'], 400);
                }
                if (Auth::user()->usdt < $request->amount) {
                    return response()->json(['error' => 'insufficient usdt'], 400);
                }

                if (Auth::user()->doge < $fee) {
                    return response()->json(['error' => 'insufficient Doge'], 400);
                }

                if ($request->amount < 0) {
                    return response()->json(['error' => 'amount cannot be less than 0'], 400);
                }

                $wallet->usdt += $request->amount;
                $wallet->save();
                Auth::user()->usdt -= $request->amount;
                Auth::user()->doge -= $fee;
                Auth::user()->save();

                //log user transfer
                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = $wallet->id;
                $log->value = '-' . $request->amount;
                $log->note = 'Tranfer usdt';
                $log->save();

                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = $wallet->id;
                $log->value = '-' . $fee;
                $log->note = 'Gas Fee Doge';
                $log->save();


                //log user transfer reciver
                $log = new Log;
                $log->reff =  $wallet->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $request->amount;
                $log->note = 'Receive usdt';
                $log->save();

                return response()->json(['success' => 'success transfered ']);
                break;
            case 'doge':
                $fee = 1;
                $wallet = User::where('wallet', $request->wallet)->first();
                if (empty($wallet)) {
                    return response()->json(['error' => 'wallet not found'], 400);
                }
                if (Auth::user()->doge < $request->amount + $fee) {
                    return response()->json(['error' => 'insufficient doge'], 400);
                }

                if ($request->amount < 0) {
                    return response()->json(['error' => 'amount cannot be less than 0'], 400);
                }

                $wallet->doge += $request->amount;
                $wallet->save();
                Auth::user()->doge -= $request->amount + $fee;
                Auth::user()->save();

                //log user transfer
                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = $wallet->id;
                $log->value = '-' . $request->amount;
                $log->note = 'Tranfer doge';
                $log->save();

                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = $wallet->id;
                $log->value = '-' . $fee;
                $log->note = 'Gas Fee Doge';
                $log->save();


                //log user transfer reciver
                $log = new Log;
                $log->reff =  $wallet->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $request->amount;
                $log->note = 'Receive doge';
                $log->save();

                return response()->json(['success' => 'success transfered ']);
                break;
        }
    }
    public function deposit(Request $request)
    {
        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['error' => 'wrong password'], 400);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['error' => 'wrong password'], 400);
            }
        }

        //chek apa sudah ada request 
        $chekDeposit = UserDeposit::where('reffid', Auth::user()->id)->where('status', 'request')->first();
        if ($chekDeposit) {
            return response()->json(['error' => 'You have requests that have not been completed'], 400);
        }

        $chekDepositReject = UserDeposit::where('reffid', Auth::user()->id)->where('status', 'reject')->first();
        if ($chekDepositReject) {
            return response()->json(['error' => 'Sorry, you were rejected from the deposit'], 400);
        }

        $deposit = new UserDeposit;
        $deposit->reffid = Auth::user()->id;
        $deposit->save();

        return response()->json(['success' => 'Succes to request deposit ']);
    }
    public function witdraw(Request $request)
    {

        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['error' => 'wrong password'], 400);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['error' => 'wrong password'], 400);
            }
        }

        if ($request->amount < 0) {
            return response()->json(['error' => 'amount cannot be less than 0'], 400);
        }


        switch ($request->token) {
            case 'usdt':
                $fee = 5;
                if (Auth::user()->usdt < $request->amount) {
                    return response()->json(['error' => 'usdt is not enough'], 400);
                }

                if (Auth::user()->doge < $fee) {
                    return response()->json(['error' => 'doge is not enough'], 400);
                }

                Auth::user()->usdt -= $request->amount;
                Auth::user()->doge -= $fee;
                Auth::user()->save();

                //masuk ke database
                $witdraw = new UserWidrawUsdt;
                $witdraw->reff = Auth::user()->id;
                $witdraw->saldo = $request->amount;
                $witdraw->wallet = $request->wallet;
                $witdraw->save();

                //logs 
                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $request->amount;
                $log->note = 'request Withdraw';
                $log->save();

                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $fee;
                $log->note = 'Gass fee doge';
                $log->save();




                return response()->json(['success' => 'Successfully withdrawn']);
                break;
            case 'doge':
                $fee = 3;
                if (Auth::user()->doge < $request->amount + $fee) {
                    return response()->json(['error' => 'doge is not enough'], 400);
                }

                Auth::user()->doge -= $request->amount + $fee;
                Auth::user()->save();

                //masuk ke database
                $witdraw = new UserWidrawDoge;
                $witdraw->reff = Auth::user()->id;
                $witdraw->saldo = $request->amount;
                $witdraw->save();

                //logs 
                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $request->amount;
                $log->note = 'request Withdraw';
                $log->save();

                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $fee;
                $log->note = 'Gass fee doge';
                $log->save();




                return response()->json(['success' => 'Successfully withdrawn']);
                break;
            case 'dogestar':
                $fee = 5;
                if (Auth::user()->saldo < $request->amount) {
                    return response()->json(['error' => 'dogestar is not enough'], 400);
                }

                if (Auth::user()->doge < $fee) {
                    return response()->json(['error' => 'doge is not enough'], 400);
                }

                Auth::user()->saldo -= $request->amount;
                Auth::user()->doge -= $fee;
                Auth::user()->save();

                //masuk ke database
                $witdraw = new UserWitdraw;
                $witdraw->reff = Auth::user()->id;
                $witdraw->saldo = $request->amount;
                $witdraw->save();

                //logs 
                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $request->amount;
                $log->note = 'request Withdraw';
                $log->save();

                $log = new Log;
                $log->reff = Auth::user()->id;
                $log->target = Auth::user()->id;
                $log->value = '-' . $fee;
                $log->note = 'Gass fee doge';
                $log->save();

                return response()->json(['success' => 'Successfully withdrawn']);
                break;
        }
    }
    public function convers(Request $request)
    {
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['error' => 'wrong password'], 400);
        }

        if ($request->amount < 0) {
            return response()->json(['error' => 'amount cannot be less than 0'], 400);
        }


        if (Auth::user()->usdt < $request->amount) {
            return response()->json(['error' => 'usdt is not enough'], 400);
        } else {
            switch ($request->token) {
                case 'doge':
                    $convers = $request->amount / doge_price();
                    Auth::user()->usdt -= $request->amount;
                    Auth::user()->doge += $convers;
                    Auth::user()->save();

                    $logs = new Log();
                    $logs->reff = Auth::user()->id;
                    $logs->target = Auth::user()->id;
                    $logs->value = $convers;
                    $logs->note = "$" . $request->amount . "->" . $convers . 'D';
                    $logs->save();

                    return response()->json(['success' => 'success Swapt to Doge']);
                    break;
                case 'xwdoge':
                    $convers = $request->amount / xwdoge_price();
                    Auth::user()->usdt -= $request->amount;
                    Auth::user()->saldo += $convers;
                    Auth::user()->save();

                    $logs = new Log();
                    $logs->reff = Auth::user()->id;
                    $logs->target = Auth::user()->id;
                    $logs->value = $convers;
                    $logs->note = "$" . $request->amount . "->" . $convers;
                    $logs->save();

                    return response()->json(['success' => 'success Swapt to Doge']);
                    break;
            }
        }
    }
    public function history(Request $request)
    {
        $logs = log::where('reff', Auth::user()->id)
            ->with('target')
            ->orderBy('created_at', 'desc')
            ->get();

        $logstakes = Logstaking::where('reff', Auth::user()->id)
            ->with('target')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'logs' => $logs,
            'logstakes' => $logstakes,
        ];

        return view('customer.sub.hystori', $data);
    }
}
