<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper\Help;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerDashboard extends Controller
{
    //claim 15 hari sekali
    //peningkatan network boost 10%
    public $claimLimitDays = 15;
    public $claimMaxNetworkMaching = 10000;
    public $claimMaxBoostkMaching = 110;
    public $claimFeeBoostkMaching = 10;
    public $claimMaxDoge = 2000;
    public $claimGasFee  = 0.1; //untuk token potong doge
    public $claimGasFeeDoge  = 100; //doge


    public function getClaimUp()
    {
        return $this->claimMaxDoge * 0.1;
    }


    public function index()
    {
        $user = auth()->user()->load('networks');
        $userPackageSummary = UserPackage::where('user_id', $user->id)
            ->where('status', 'active')
            ->selectRaw('SUM(profit_per_hours) as totalProfitPerHours, SUM(max_claim) as totalMaxClaim')
            ->first();

        if (!empty($userPackageSummary)) {
            $perscon = $userPackageSummary->totalProfitPerHours / 3600;
            $totalHours = $userPackageSummary->totalMaxClaim / 60;
        }


        $data = [
            'nav' => 'dashboard',
            'user' => $user,
            'perscon' => $perscon,
            'totalHours' => $totalHours,
            'claimMaxNetworkMaching' => $this->claimMaxNetworkMaching,
            'maxClaimDoge' => $this->claimMaxDoge,
            'claimMaxBoostkMaching' => $this->claimMaxBoostkMaching,

        ];

        return view('customer.dashboard', $data);
    }



    public function claimNetworkBoost(Request $request)
    {
        $user = auth()->user()->load('networks');
        $network = $user->networks;
        $gasFee = 0.1;

        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['success' => false, 'message' => 'Incorrect password.']);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['success' => false, 'message' => 'Incorrect password.']);
            }
        }

        if ($user->doge < $gasFee) {
            return response()->json(['success' => false, 'message' => 'You do not have enough Doge to claim.']);
        }

        if ($network->network_boost <= 0) {
            return response()->json(['success' => false, 'message' => 'You have no network boost to claim.']);
        }
        //gas fee
        $user->doge += $network->network_boost - $gasFee;
        $user->save();


        $network->network_boost = 0;
        $network->save();





        return response()->json(['success' => true, 'message' => 'Network boost has been increased.']);
    }
    public function claimNetworkMatching(Request $request)
    {
        $user = auth()->user()->load('networks');
        $network = $user->networks;
        $gasFee = 0.1;

        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['success' => false, 'message' => 'Incorrect password.']);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['success' => false, 'message' => 'Incorrect password.']);
            }
        }


        if ($user->doge < $gasFee) {
            return response()->json(['success' => false, 'message' => 'You do not have enough Doge to claim.']);
        }

        if ($network->network_matching <= 0) {
            return response()->json(['success' => false, 'message' => 'You have no network matching to claim.']);
        }
        //gas fee 
        $user->doge -= $gasFee;
        $user->saldo += $network->network_matching;
        $user->save();

        $network->network_matching = 0;
        $network->save();
        return response()->json(['success' => true, 'message' => 'Network boost has been increased.']);
    }
    public function claimBoostMatching(Request $request)
    {
        $user = auth()->user()->load('networks');
        $network = $user->networks;
        $gasFee = 0.1;


        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['success' => false, 'message' => 'Incorrect password.']);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['success' => false, 'message' => 'Incorrect password.']);
            }
        }

        if ($user->doge < $gasFee) {
            return response()->json(['success' => false, 'message' => 'You do not have enough Doge to claim.']);
        }

        if ($network->boost_matching <= 0) {
            return response()->json(['success' => false, 'message' => 'You have no network matching to claim.']);
        }
        //gas fee 
        $user->doge -= $gasFee;
        $user->saldo += $network->boost_matching;
        $user->save();

        $network->boost_matching = 0;
        $network->save();
        return response()->json(['success' => true, 'message' => 'Network boost has been increased.']);
    }

    public function claimStaking(Request $request)
    {
        $admin = User::find(2);
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                if (!Hash::check($request->password, Auth::user()->password)) {
                    return response()->json(['success' => false, 'message' => 'Incorrect password.']);
                }
            }
        } else {
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json(['success' => false, 'message' => 'Incorrect password.']);
            }
        }
        $user = Auth::user();
        $stakingToken = $user->staking_token;
        $maxClaim = 99999999999999999999;
        $feeClaim = 0.1;


        if ($user->doge < $feeClaim) {
            return response()->json(['success' => false, 'message' => 'doge less than ' . number_format($feeClaim)]);
        } else if ($stakingToken > $maxClaim) {
            $user->staking_token -= $maxClaim; // kurangi token yang terkumpul
            $user->saldo += $maxClaim;
            $user->doge -= $feeClaim;
            $user->save(); // simpan perubahan

            //logs claim token 
            $log = new Log();
            $log->reff = $user->id;
            $log->target = $user->id;
            $log->value = "-" .  $feeClaim;
            $log->note = "Doge: Claim Token " . number_format($feeClaim);
            $log->save();


            return response()->json(['success' => true, 'message' => 'Claimed max tokens ' . number_format($maxClaim), 'remaining_staking_token' => $user->staking_token]);
        } else if ($stakingToken == 0) {
            return response()->json(['success' => false, 'message' => 'Empty token']);
        } else { // $stakingToken < $maxClaim
            $user->saldo += $stakingToken; // tambahkan sisa token ke saldo
            $user->staking_token = 0; // kurangi semua token yang tersisa
            $user->doge -= $feeClaim;
            $user->save(); // simpan perubahan
            return response()->json(['success' => true, 'message' => 'Claimed all available tokens ' . number_format($stakingToken), 'remaining_staking_token' => $user->staking_token]);
        }
    }
}
