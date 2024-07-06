<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\Help;
use App\Models\Bonus;
use App\Models\Log;
use App\Models\Package as ModelsPackage;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class Package extends Controller
{
    public function index()
    {
        $data = [
            'packages' => ModelsPackage::orderBy('price', 'asc')->get(),
        ];

        return view('customer.package', $data);
    }
    public function buy(Request $request)
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


        $package = ModelsPackage::find($request->id);
        if (!$package) {
            return response()->json(['error' => 'Package not found']);
        }


        if ($package->price == 0 && Auth::user()->bonus_active == 'active') {
            return response()->json(['error' => 'You already have a Boost']);
        }

        if ($package->price == 0 && Auth::user()->bonus_active == 'nonactive') {
            Auth::user()->bonus_active = 'active';
        }


        if (Auth::user()->doge < $package->price) {
            return response()->json(['error' => 'Insufficient Doge balance']);
        } else {
            if (Auth::user()->status != 'active') {
                $reff = User::find(Auth::user()->upline);
                if ($reff) {
                    for ($i = 0; $i < 3; $i++) {
                        $reff->saldo += 1000;
                        $reff->save();
                        if ($reff->upline) {
                            $reff = User::find($reff->upline);
                        } else {
                            break;
                        }
                    }
                }
            }


            Auth::user()->doge -= $package->price;
            Auth::user()->status = 'active';
            Auth::user()->save();



            UserPackage::create([
                'user_id' => Auth::user()->id,
                'package_id' => $package->id,
                'profit_per_hours' => $package->total_profit / $package->hours,
                'max_claim' => $package->hours * 60, //claim permenit
                'claim_time' => Carbon::now()->addMinutes(1),
            ]);

            //logs kurangi saldo
            $log = new Log;
            $log->reff = Auth::user()->id;
            $log->target = Auth::user()->id;
            $log->value = "-" .  $package->price;
            $log->note = "Boost " . number_format($package->price);
            $log->save();


            //jika ada upline berikan bonus 1 tingkat
            if (!empty(Auth::user()->upline)) {

                $bonusReff = ($package->price / 100) * env("BONUS_REFF", 1);
                $uplineUser = User::find(Auth::user()->upline);
                $uplineUser->usdt += $bonusReff;
                $uplineUser->bonus_downline += $bonusReff;
                $uplineUser->save();

                $log = new Log;
                $log->reff = Auth::user()->upline;
                $log->target = Auth::user()->id;
                $log->value = "+" .  $bonusReff;
                $log->note = "Bonus Reff";
                $log->save();

                $levels = 3;
                $tempreff = Auth::user()->upline;
                for ($i = 0; $i < $levels; $i++) {
                    $uplineUser = User::find($tempreff)->with('networks');
                    if (empty($uplineUser->networks)) {
                        break;
                    }
                    $uplineUser->networks->network_boost += $package->price * 0.01;
                    $uplineUser->networks->network_matching += $package->price * 0.01;
                    $uplineUser->networks->save();
                    if ($uplineUser->upline) {
                        $tempreff = $uplineUser->upline;
                    } else {
                        break;
                    }
                }
            }







            return response()->json(['success' => 'Done']);
        }
    }

    public function sendBonusReff($data, $price)
    {
        $bonus = Help::percentage($price, env('BONUS_REFF'));

        $log = new Log;
        $log->reff = $data->reffid;
        $log->target = Auth::user()->id;
        $log->value = '+' . $bonus;
        $log->note = 'Bonus Agent';
        $log->save();
        DB::table('users')->where('id', $data->reffid)->increment('saldo', $bonus);
    }

    public function chekPackage(Request $request)
    {

        $id = decrypt($request->id);

        $package = DB::table('user_packages')->where('id', $id)->first();

        $unixTime = strtotime($package->created_at); // Unix time yang ingin Anda tambahkan 1 bulan

        // Konversi Unix time menjadi format tanggal
        $date = date('Y-m-d', $unixTime);

        // Tambahkan 1 bulan ke dalam tanggal
        $nextMonth = date('Y-m-d', strtotime('+3 month', strtotime($date)));

        // Konversi kembali ke dalam format Unix time
        $unixTimeNextMonth = strtotime($nextMonth);

        return response()->json($unixTimeNextMonth <= strtotime('now'));
    }

    public function stop(Request $request)
    {
        return back();
        $id = decrypt($request->id);
        $package = DB::table('user_packages')
            ->join('packages', 'user_packages.reffpackage', '=', 'packages.id')
            ->where('user_packages.id', $id)
            ->select('packages.price as price', 'user_packages.created_at as created_at')
            ->first();
        if (empty($package)) {
            return back();
        }

        $unixTime = strtotime($package->created_at); // Unix time yang ingin Anda tambahkan 1 bulan

        // Konversi Unix time menjadi format tanggal
        $date = date('Y-m-d', $unixTime);

        // Tambahkan 1 bulan ke dalam tanggal
        $nextMonth = date('Y-m-d', strtotime('+3 month', strtotime($date)));

        // Konversi kembali ke dalam format Unix time
        $unixTimeNextMonth = strtotime($nextMonth);

        if ($unixTimeNextMonth <= strtotime('now')) {
            DB::table('users')->where('id', Auth::user()->id)->increment('usdt', $package->price);
            DB::table('user_packages')->where('id', $id)->delete();

            Log::create([
                'reff' => Auth::user()->id,
                'target' => Auth::user()->id,
                'value' => '+ ' . $package->price,
                'note' => 'Stop Staking'
            ]);
        } else {
            DB::table('users')->where('id', Auth::user()->id)->increment('usdt', $package->price * 0.5);
            DB::table('user_packages')->where('id', $id)->delete();
            Log::create([
                'reff' => Auth::user()->id,
                'target' => Auth::user()->id,
                'value' => '+ ' . $package->price * 0.5,
                'note' => 'Stop Staking'
            ]);
        }
        Alert::success('Success', 'You have successfully stopped staking $' . number_format($package->price));
        return back();
    }

    public function claimBonus(Request $request)
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

        if (Auth::user()->bonus_active == "nonactive") {
            Alert::error('Sorry', 'You must have staked at least $1000');
            return back();
        }



        $bonus = Bonus::find($request->id);

        if (Auth::user()->bonus < $bonus->bonus) {
            Alert::error('Sorry', 'Your bonus is not yet active');
            return back();
        }

        $claimBonus = $bonus->bonus * $bonus->percentage * $this->priceCoin;

        User::where('id', Auth::user()->id)->increment('saldo', $claimBonus);
        User::where('id', Auth::user()->id)->decrement('bonus', $bonus->bonus);

        //log bonus
        $log = new Log;
        $log->reff = Auth::user()->id;
        $log->target = Auth::user()->id;
        $log->value = '+' . $claimBonus;
        $log->note = 'Claim Bonus poodlepet';
        $log->save();

        Alert::success('Success', 'Success Claim');
        return back();
    }
}
