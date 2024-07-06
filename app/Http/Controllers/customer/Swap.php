<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Swap extends Controller
{
    function index()
    {
        $data = [
            'nav' => 'Swap',
        ];
        return view('customer.swap', $data);
    }
}
