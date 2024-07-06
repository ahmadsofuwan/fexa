<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Reward;
use App\Models\Logstaking;
use App\Models\Network;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Staking extends Controller
{
    function stake()
    {
        $userPackage = UserPackage::where('claim_time', '<', now())
            ->where('status', 'active')
            ->with('user')
            ->get();
        foreach ($userPackage as $key => $value) {
            $subUserPackage = UserPackage::find($value->id);
            if ($value->claimed >= $value->max_claim) { //chek jika sudah max 
                $subUserPackage->status = 'nonactive';
                $subUserPackage->save();
                continue;
            }
            $subUserPackage->user->staking_token += $subUserPackage->profit_per_hours / 60; //di jadikan permenit
            $subUserPackage->user->save();
            $subUserPackage->claimed += 1;
            $subUserPackage->claim_time = Carbon::parse($subUserPackage->claim_time)->addMinutes(1);
            $subUserPackage->save();

            //logs Staking
            $log = new Logstaking;
            $log->reff = $subUserPackage->user->id;
            $log->target = $subUserPackage->user->id;
            $log->value = "+" .  $subUserPackage->profit_per_hours / 60;
            $log->note = "Mining " . number_format($subUserPackage->profit_per_hours);
            $log->save();



            $tempUpline = $subUserPackage->user->upline;
            for ($i = 0; $i < 3; $i++) {
                if (!empty($tempUpline)) {
                    $uplineUser = Network::where('user_id', $tempUpline)->first();
                    $uplineUser->boost_matching += $subUserPackage->profit_per_hours / 60;
                    $uplineUser->save();
                    $tempUpline = $uplineUser->upline;

                    //logs bonus staking group
                    $log = new Log;
                    $log->reff = $uplineUser->id;
                    $log->target = $subUserPackage->user->id;
                    $log->value = "+" .  $subUserPackage->profit_per_hours / 60;
                    $log->note = "Bonus Network " . number_format($subUserPackage->profit_per_hours / 60);
                    $log->save();
                } else {
                    break;
                }
            }
        }
        return response()->json(['staking' => count($userPackage)]);
    }
}
