<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper\Help;
use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class Auth extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (FacadesAuth::attempt($credentials)) {
            if (FacadesAuth::user()->role == 'admin') {
                return redirect()->intended(route('dashboard.admin'));
            }

            return redirect()->intended(route('dashboard'));
        }
        Alert::error('Error', 'Incorrect Wallet Address or Password');
        return back()->withInput();
    }
    public function logout(Request $request)
    {
        FacadesAuth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function register(Request $request)
    {
        $data = [
            'request' => $request,
        ];
        return view('register', $data);
    }
    public function registerSave(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'wallet' => 'required|unique:users',
            'reff' => 'required',
            'phone' => ['required', 'numeric',]
        ], [
            'reff.required' => 'The agent field is required',
        ]);
        $reffid = 0;
        if (!empty($request->reff)) {
            $reff = User::where('username', trim($request->reff))->where('status', 'active')->first();
            if (empty($reff)) {
                return back()->withErrors(['reff' => 'Agent not found'])->withInput();
            } else {

                if ($reff->status = 'active') {
                    return back()->withErrors(['reff' => 'Agent not active'])->withInput();
                } else {
                    $reffid = $reff->id;
                    $reff->bonus_downline += 1000;
                    $reff->save();
                }
            }
        }


        $user = new User;
        $user->role = 'customer';
        $user->username = trim($request->wallet);
        $user->password = bcrypt(trim($request->password));
        $user->phone = trim($request->phone);
        $user->upline = $reffid;
        $user->wallet = trim($request->wallet);
        $user->save();

        Network::create([
            'user_id' => $user->id,
        ]);


        return redirect()->route('login');
    }
    function forget()
    {
        return view('forget');
    }
    function forgetAction(Request $request)
    {
        if (empty($request->username)) {
            return back()->withErrors(['username' => 'Wallet Address is required'])->withInput();
        }

        $user = User::where('username', $request->username)->first();
        if (empty($user)) {
            return back()->withErrors(['username' => 'Wallet Address not found'])->withInput();
        }
        $maskedPhone = str_repeat('*', strlen($user->phone) - 3) . substr($user->phone, -3);

        $otp = Str::random(4);
        User::where('id', $user->id)->update([
            'otp' => $otp,
        ]);
        //kirim otp
        $response = Http::post('http://onesender.onemonbot.com:5570/api/send-message', [
            'api_key' => '9280715d134abaeea843f7b48cdcab1e808aa0d4',
            'receiver' => Help::formatPhone($user->phone),
            'data' => [
                'message' => 'this is your secret code ' . $otp,
            ]
        ]);

        // Cek status response
        if ($response->successful()) {
            // Permintaan berhasil
            $responseData = $response->json(); // Data balasan dalam bentuk JSON
        } else {
            // Permintaan gagal
            $errorResponse = $response->json(); // Data balasan error dalam bentuk JSON
        }


        $data = [
            'user' => $user,
            'maskedPhone' => $maskedPhone,
        ];

        return view('otp', $data);
    }
    function otp(Request $request)
    {
        $user = User::where('username', $request->username)->where('otp', $request->otp)->first();
        if (empty($user)) {
            Alert::error('Sorry', 'OTP invalid');
            return back()->withInput();
        }

        $data = [
            'user' => $user,
        ];
        return view('change', $data);
    }
    function change(Request $request)
    {
        if ($request->password != $request->password2) {
            Alert::error('Sorry', 'Confirm password is wrong');
            return back();
        }
        User::where('username', $request->username)->where('otp', $request->otp)->update([
            'password' => bcrypt(trim($request->password))
        ]);
        Alert::success('Success', 'Succes change password');
        return redirect()->route('login');
    }
}
