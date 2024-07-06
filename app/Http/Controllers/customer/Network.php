<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Help;
use App\Models\Bonus;
use App\Models\UserBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class Network extends Controller
{
    public function index()
    {
        $bonus = DB::table('bonuses')->get();
        $ref_l = $this->getReff('left');
        $ref_r = $this->getReff('rigth');
        $bonusClaimed = DB::table('user_bonuses')->where('reffid', Auth::user()->id)->select('claimed')->first()->claimed;
        $bonus = 0;

        if ($ref_l < $ref_r) {
            $bonus = $ref_l;
        } else {
            $bonus = $ref_r;
        }
        $rank = DB::table('ranks')->where('rank', '<=', $bonus)->orderByDesc('rank')->first();

        $bonus = Help::percentage($bonus, 10) - $bonusClaimed;




        $data = [
            'nav' => 'Network',
            'user' => Auth::user(),
            'left' => $ref_l,
            'rigth' =>  $ref_r,
            'bonus' => $bonus,
            'claimed' => $bonusClaimed,
            'rank' => empty($rank) ? 'free' :  $rank->name,
        ];
        return view('customer.network', $data);
    }

    public function getReffOld($target, $pkey = '')
    {
        $totalPrice = 0;
        if (empty($pkey)) { //untuk pertama
            $reffKey = Auth::user()->id;
            $reff = DB::table('referals')
                ->join('user_packages', 'referals.' . $target, '=', 'user_packages.reffid')
                ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
                ->where('referals.reffid', $reffKey)
                ->where('packages.status', '!=', 'promo')
                ->where($target, '!=', null)
                ->select('packages.*', 'user_packages.reffid as reffid')
                ->get();
            $totalPrice = $reff->sum('price');
            //loping ulang data nya 
            foreach ($reff as $reffValue) {
                $totalPrice += $this->getReff('center', $reffValue->reffid);
            }
        } else {
            $reffKey = $pkey;


            //ambil data kiri
            $target = 'left';
            $reff_l = DB::table('referals')
                ->join('user_packages', 'referals.' . $target, '=', 'user_packages.reffid')
                ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
                ->where('referals.reffid', $reffKey)
                ->where('packages.status', '!=', 'promo')
                ->where($target, '!=', null)
                ->select('packages.*', 'user_packages.reffid as reffid')
                ->get();
            Log::debug(print_r($reff_l, true));
            //ambil data kanan
            $target = 'rigth';
            $reff_r = DB::table('referals')
                ->join('user_packages', 'referals.' . $target, '=', 'user_packages.reffid')
                ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
                ->where('referals.reffid', $reffKey)
                ->where('packages.status', '!=', 'promo')
                ->where($target, '!=', null)
                ->select('packages.*', 'user_packages.reffid as reffid')
                ->get();
            foreach ($reff_l as $val_l) {
                $totalPrice += $this->getReff('center', $val_l->reffid);
            }

            foreach ($reff_r as $val_r) {
                $totalPrice += $this->getReff('center', $val_r->reffid);
            }
        }

        return $totalPrice;
    }

    public function getReff($target, $pkey = '')
    {
        $totalPrice = 0;
        $reffKey = (empty($pkey)) ? Auth::user()->id : $pkey;

        if (empty($pkey)) {
            $reff = DB::table('referals')
                ->join('user_packages', 'referals.' . $target, '=', 'user_packages.reffid')
                ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
                ->where('referals.reffid', $reffKey)
                ->where('packages.status', '!=', 'promo')
                ->where($target, '!=', null)
                ->select('packages.*', 'user_packages.reffid as reffid')
                ->get();
            $totalPrice = $reff->sum('price');
            //loping ulang data nya 
            foreach ($reff as $reffValue) {
                $totalPrice += $this->getReff('center', $reffValue->reffid);
            }
            return $totalPrice;
        }




        //ambil data kiri
        $target = 'left';
        $reff_l = DB::table('referals')
            ->join('user_packages', 'referals.' . $target, '=', 'user_packages.reffid')
            ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
            ->where('referals.reffid', $reffKey)
            ->where('packages.status', '!=', 'promo')
            ->where($target, '!=', null)
            ->select('packages.*', 'user_packages.reffid as reffid')
            ->get();
        //ambil data kanan
        $target = 'rigth';
        $reff_r = DB::table('referals')
            ->join('user_packages', 'referals.' . $target, '=', 'user_packages.reffid')
            ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
            ->where('referals.reffid', $reffKey)
            ->where('packages.status', '!=', 'promo')
            ->where($target, '!=', null)
            ->select('packages.*', 'user_packages.reffid as reffid')
            ->get();
        $totalPrice = $reff_l->sum('price') + $reff_r->sum('price');

        //loping ulang data nya 
        foreach ($reff_l as $reffValue) {
            $totalPrice += $this->getReff('center', $reffValue->reffid);
        }

        foreach ($reff_r as $reffValue) {
            $totalPrice += $this->getReff('center', $reffValue->reffid);
        }

        return $totalPrice;
    }


    public function claimBonus()
    {
        $ref_l = $this->getReff('left');
        $ref_r = $this->getReff('rigth');
        $bonusClaimed = DB::table('user_bonuses')->where('reffid', Auth::user()->id)->select('claimed')->first()->claimed;
        $bonus = 0;

        if ($ref_l < $ref_r) {
            $bonus = $ref_l;
        } else {
            $bonus = $ref_r;
        }

        $bonus = Help::percentage($bonus, 10) - $bonusClaimed;
        if ($bonus <= 0) {
            Alert::error('Sorry', 'no bonuses claimed');
            return back();
        }
        //tambah saldo dia 
        DB::table('users')->where('id', Auth::user()->id)->increment('saldo', $bonus);
        DB::table('user_bonuses')->where('reffid', Auth::user()->id)->increment('claimed', $bonus);


        Alert::success('Success', 'Success claim bonus');
        return back();
    }
}
