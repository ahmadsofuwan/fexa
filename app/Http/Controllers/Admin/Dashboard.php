<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index(Request $request)
    {
        $customerData = DB::table('users')
            ->where('role', 'customer')
            ->selectRaw('
                COUNT(*) as customer_count, 
                SUM(saldo) as total_saldo, 
                SUM(usdt) as total_usdt, 
                SUM(doge) as total_doge
            ')
            ->first();

        $data = [
            'nav' => 'Dashboard',
            'customer' => $customerData->customer_count,
            'saldo' => $customerData->total_saldo,
            'usdt' => $customerData->total_usdt,
            'doge' => $customerData->total_doge,
            
        ];
        return view('admin.dashboard', $data);
    }
}
