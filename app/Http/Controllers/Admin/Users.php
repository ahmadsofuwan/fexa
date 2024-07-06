<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Users extends Controller
{
    public function index()
    {

        $users = DB::table('users')
            ->leftJoin('user_packages', 'users.id', '=', 'user_packages.user_id')
            ->leftJoin('packages', 'user_packages.package_id', '=', 'packages.id')
            ->select(
                DB::raw('COUNT(user_packages.id) as totalpackage'),
                DB::raw('SUM(packages.price) as totalprice'),
                'users.username as username',
                'users.created_at as created_at',
                'users.usdt as usdt',
                'users.id as id',
                'users.saldo as saldo',
                'users.role as role',
                'users.phone as phone',
                'users.wallet as wallet',
                'users.doge as doge',
            )
            ->groupBy('users.id')
            ->get();
        $data = [
            'nav' => 'Users',
            'users' => $users,
        ];

        return view('admin.user', $data);
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        DB::table('users')->where('id', $id)->delete();
        Alert::success('Success', 'data deleted successfully');
        return back();
    }

    public function login($id)
    {
        Auth::loginUsingId(Crypt::decrypt($id));
        Alert::success('Success', 'successfully logged in to ' . Auth::user()->username . ' account');
        return redirect()->intended(route('dashboard'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'phone' => ['required'],
            'wallet' => ['required'],
            'role' => ['required'],
            'saldo' => ['required'],
            'usdt' => ['required'],
        ]);
        $id = decrypt($request->id);
        $user = User::find($id);
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->wallet = $request->wallet;
        $user->role = $request->role;
        $user->saldo = $request->saldo;
        $user->usdt = $request->usdt;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        Alert::success('Success', 'successful change of data');
        return back();
    }
}
