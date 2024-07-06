<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Profile extends Controller
{
    public $max = 3000;
    public $gasfee = 1;
    //di dapatkan dari setiap referal 1000  masuk ke doge star

    public function index()
    {
        if (Auth::user()->upline == null) {
            $wa = '#';
        } else {
            $upline = User::find(Auth::user()->upline);
            $wa = phone_to_whatsapp_link($upline->phone);
        }

        $downline = User::where('upline', Auth::user()->id)->get();

        $data = [
            'user' => Auth::user(),
            'wa' => $wa,
            'downline' => $downline,
        ];
        return view('customer.profile', $data);
    }

    public function team($ids, $level = 1)
    {
        $res = 0;
        foreach ($ids as $id) {
            $temp = DB::table('users')->where('upline', $id)->pluck('id');
            $res += count($temp);
            if (count($temp) != 0 && $level < 7) {
                $res += $this->team($temp, $level + 1);
            }
        }
        return $res;
    }
    public function omset($ids, $level = 1)
    {
        $res = DB::table('user_packages')
            ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
            ->whereIn('user_packages.reffid', $ids)
            ->sum('packages.price');
        if ($level < 7) {
            foreach ($ids as $id) {
                $temp = DB::table('users')->where('upline', $id)->pluck('id');
                if (count($temp) != 0) {
                    $res += $this->omset($temp, $level + 1);
                }
            }
        }
        return $res;
    }

    public function claim()
    {
        $user = Auth::user();
        if ($user->bonus_downline <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient downline bonus'
            ]);
        }

        if ($user->doge < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient DOGE'
            ]);
        }

        $user->doge -= 1;
        if ($user->bonus_downline >= $this->max) {
            $user->bonus_downline -= $this->max;
            $user->saldo += $this->max;
        } else {
            $user->saldo += $user->bonus_downline;
            $user->bonus_downline = 0;
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Claim success'
        ]);
    }
}
