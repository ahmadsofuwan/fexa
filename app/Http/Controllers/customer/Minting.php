<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Minting extends Controller
{
    public function index()
    {
        $userPackage = UserPackage::where('user_id', Auth::user()->id)->get();
        $downline = User::where('upline', Auth::user()->id)->count();

        $data = [
            'users' => Auth::user(),
            'userPackage' => $userPackage,
            'minting' => Auth::user()->staking_token,
            'downline' => $downline,
        ];

        return view('customer.minting', $data);
    }

    public function claim(Request $request)
    {
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['error' => 'wrong password']);
        }


        $user = Auth::user();
        $stakingToken = $user->staking_token;
        $maxClaim = 99999999999999999999;
        $feeClaim = 0.1;


        if ($user->doge < $feeClaim) {
            return response()->json(['error' => 'doge less than ' . number_format($feeClaim)]);
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


            return response()->json(['success' => 'Claimed max tokens ' . number_format($maxClaim), 'remaining_staking_token' => $user->staking_token]);
        } else if ($stakingToken == 0) {
            return response()->json(['error' => 'Empty token']);
        } else { // $stakingToken < $maxClaim
            $user->saldo += $stakingToken; // tambahkan sisa token ke saldo
            $user->staking_token = 0; // kurangi semua token yang tersisa
            $user->doge -= $feeClaim;
            $user->save(); // simpan perubahan
            return response()->json(['success' => 'Claimed all available tokens ' . number_format($stakingToken), 'remaining_staking_token' => $user->staking_token]);
        }
    }

    public function claim_group(Request $request)
    {
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['error' => 'wrong password']);
        }


        $user = Auth::user();
        $bonusToken = $user->bonus;
        $maxClaim = env('MAX_CLAIM', 300);
        $feeClaim = env('FEE_CLAIM', 100);
        if ($user->doge < $feeClaim) {
            return response()->json(['error' => 'doge less than ' . number_format($feeClaim)]);
        } else if ($bonusToken > $maxClaim) {
            $user->bonus -= $maxClaim; // kurangi token yang terkumpul
            $user->saldo += $maxClaim;
            $user->doge -= $feeClaim;
            $user->last_bonus_claim = now();
            $user->save(); // simpan perubahan

            //logs claim token 
            $log = new Log();
            $log->reff = $user->id;
            $log->target = $user->id;
            $log->value = "-" .  $feeClaim;
            $log->note = "Doge: Claim Bonus Token " . number_format($feeClaim);
            $log->save();


            return response()->json(['success' => 'Claimed max tokens ' . number_format($maxClaim), 'remaining_staking_token' => $user->bonus]);
        } else if ($bonusToken == 0) {
            return response()->json(['error' => 'Empty Tsoken Bonus']);
        } else { // $stakingToken < $maxClaim
            $user->saldo += $bonusToken; // tambahkan sisa token ke saldo
            $user->bonus = 0; // kurangi semua token yang tersisa
            $user->doge -= $feeClaim;
            $user->last_bonus_claim = now();
            $user->save(); // simpan perubahan
            return response()->json(['success' => 'Claimed all available tokens ' . number_format($bonusToken), 'remaining_staking_token' => $user->bonus]);
        }
    }

    public function detail()
    {
        $userPackage = UserPackage::with('package')->where('user_id', Auth::user()->id)->where('status', 'active')->get();

        $data = [
            'userPackage' => $userPackage,
        ];
        return view('customer.sub.detail_peckage', $data);
    }
}
