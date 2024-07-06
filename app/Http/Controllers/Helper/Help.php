<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class Help extends Controller
{
    public static function getRef($langth)
    {
        
        $rigth = Str::random($langth);
        $left = Str::random($langth);

        while (User::where('r_referral', $rigth)->exists()) { //chek rigth sudah ada apa belum
            $rigth = Str::random($langth);
        }
        while (User::where('l_referral', $left)->exists()) { //chek rigth sudah ada apa belum
            $rigth = Str::random($langth);
        }

        return [
            'rigth' => $rigth,
            'left' => $left,
        ];
    }
    public static function formatPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (Str::startsWith($phone, '08')) {
            return '628' . Str::substr($phone, 2);
        }
        return $phone;
    }
    public static function percentage($value, $percentage)
    {
        return $value * ($percentage / 100);
    }

    public static function timeToPercent($to)
    {
        // Mendapatkan waktu saat ini
        $current_time = strtotime('now');


        // Menghitung selisih waktu dalam detik
        $time_diff =  $to - $current_time;

        // Menghitung persentase waktu
        $percent = ((24 * 60 * 60 - $time_diff) / (24 * 60 * 60)) * 100;

        //maximal 100 
        if ($percent > 100) {
            $percent = 100;
        }
        if ($percent < 0) {
            $percent = 0;
        }

        // Mencetak hasil
        return $percent;
    }

    public static function compressNumber($number)
    {
        if ($number < 1000) {
            return (string)$number;
        } elseif ($number < 1000000) {
            return number_format($number / 1000, 1) . 'k';
        } else {
            return number_format($number / 1000000, 1) . 'm';
        }
    }
}
