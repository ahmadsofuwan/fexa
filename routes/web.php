<?php

use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthCheckMiddleware;
use App\Http\Middleware\AuthCustomer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|   
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/delete/user', [App\Http\Controllers\Staking::class, 'deleteUser']);
Route::get('/login', [App\Http\Controllers\Auth::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth::class, 'login'])->name('login.auth');
Route::get('/register', [App\Http\Controllers\Auth::class, 'register'])->name('register');
Route::post('/register/save', [App\Http\Controllers\Auth::class, 'registerSave'])->name('register.save');
Route::get('/staking/run', [App\Http\Controllers\Staking::class, 'stake']);
Route::get('/forget', [App\Http\Controllers\Auth::class, 'forget'])->name('forget');
Route::post('/forget', [App\Http\Controllers\Auth::class, 'forgetAction'])->name('forget.action');
Route::post('/otp', [App\Http\Controllers\Auth::class, 'otp'])->name('forget.otp');
Route::post('/change', [App\Http\Controllers\Auth::class, 'change'])->name('forget.change');
Route::get('/reset/stock', [App\Http\Controllers\Admin\Package::class, 'resetStock'])->name('package.admin.reset');




Route::middleware([AuthCheckMiddleware::class])->group(function () {
    Route::get('/claim/{id}', [App\Http\Controllers\CustomerDashboard::class, 'claim']);
    Route::get('/logout', [App\Http\Controllers\Auth::class, 'logout'])->name('logout');


    //customer 
    Route::middleware([AuthCustomer::class])->group(function () {
        Route::get('/', [App\Http\Controllers\CustomerDashboard::class, 'index'])->name('dashboard');
        Route::post('/claim-network-boost', [App\Http\Controllers\CustomerDashboard::class, 'claimNetworkBoost'])->name('claim_network_boost');
        Route::post('/claim-network-matching', [App\Http\Controllers\CustomerDashboard::class, 'claimNetworkMatching'])->name('claim_network_matching');
        Route::post('/claim-boost-matching', [App\Http\Controllers\CustomerDashboard::class, 'claimBoostMatching'])->name('claim_boost_matching');
        Route::post('/claim-staking', [App\Http\Controllers\CustomerDashboard::class, 'claimStaking'])->name('claim_staking');

        Route::prefix('swap')->group(function () {
            Route::get('/', [App\Http\Controllers\customer\Swap::class, 'index'])->name('swap');
        });
        Route::prefix('packages')->group(function () {
            Route::get('/', [App\Http\Controllers\customer\Package::class, 'index'])->name('packages');
            Route::post('/buy', [App\Http\Controllers\customer\Package::class, 'buy'])->name('packages.buy');
            Route::post('/chek/package', [App\Http\Controllers\customer\Package::class, 'chekPackage'])->name('packages.chek');
            Route::get('/stop/package', [App\Http\Controllers\customer\Package::class, 'stop'])->name('packages.stop');
            Route::post('/claim/bonus', [App\Http\Controllers\customer\Package::class, 'claimBonus'])->name('packages.claim.bonus');
        });
        Route::prefix('network')->group(function () {
            Route::get('/', [App\Http\Controllers\customer\Network::class, 'index'])->name('network');
            Route::get('/claim', [App\Http\Controllers\customer\Network::class, 'claimBonus'])->name('network.claim');
        });
        Route::prefix('minting')->group(function () {
            Route::get('/', [App\Http\Controllers\customer\Minting::class, 'index'])->name('minting');
            Route::post('/claim', [App\Http\Controllers\customer\Minting::class, 'claim'])->name('minting.claim');
            Route::post('/claim/bonus', [App\Http\Controllers\customer\Minting::class, 'claim_group'])->name('minting.claim.bonus');
            Route::post('/detail', [App\Http\Controllers\customer\Minting::class, 'detail'])->name('minting.detail');
        });

        Route::prefix('profile')->group(function () {
            Route::get('/', [App\Http\Controllers\customer\Profile::class, 'index'])->name('profile');
            Route::post('/claim/bonusdownline', [App\Http\Controllers\customer\Profile::class, 'claim'])->name('profile.claim');
        });

        Route::prefix('wallet')->group(function () {
            Route::get('/', [App\Http\Controllers\customer\Wallet::class, 'index'])->name('wallet');
            Route::post('/', [App\Http\Controllers\customer\Wallet::class, 'transfer'])->name('transfer');
            Route::post('/deposit', [App\Http\Controllers\customer\Wallet::class, 'deposit'])->name('wallet.deposit');
            Route::post('/witdraw', [App\Http\Controllers\customer\Wallet::class, 'witdraw'])->name('wallet.witdraw');
            Route::post('/witdraw/usdt', [App\Http\Controllers\customer\Wallet::class, 'witdrawUsdt'])->name('wallet.witdraw.usdt');
            Route::post('/convers', [App\Http\Controllers\customer\Wallet::class, 'convers'])->name('wallet.convers');
            Route::post('/history', [App\Http\Controllers\customer\Wallet::class, 'history'])->name('wallet.history');
        });
    });


    //admin
    Route::middleware([AuthAdmin::class])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\Dashboard::class, 'index'])->name('dashboard.admin');

            Route::prefix('package')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\Package::class, 'index'])->name('package.admin');
                Route::post('/add', [App\Http\Controllers\Admin\Package::class, 'add'])->name('package.admin.add');
                Route::post('getbyid', [App\Http\Controllers\Admin\Package::class, 'getById'])->name('package.admin.get');
                Route::post('update', [App\Http\Controllers\Admin\Package::class, 'update'])->name('package.admin.update');
                Route::get('delete/{id}', [App\Http\Controllers\Admin\Package::class, 'delete'])->name('package.admin.delete');
            });
            Route::prefix('user')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\Users::class, 'index'])->name('users.admin');
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\Users::class, 'delete'])->name('users.admin.delete');
                Route::get('/login/{id}', [App\Http\Controllers\Admin\Users::class, 'login'])->name('users.admin.login');
                Route::post('/edit', [App\Http\Controllers\Admin\Users::class, 'edit'])->name('users.admin.edit');
            });
            Route::prefix('deposit')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\Deposit::class, 'index'])->name('deposit.admin');
                Route::get('/reject/{id}', [App\Http\Controllers\Admin\Deposit::class, 'reject'])->name('deposit.reject.admin');
                Route::post('/accept', [App\Http\Controllers\Admin\Deposit::class, 'accept'])->name('deposit.accept.admin');
            });
            Route::prefix('witdraw')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\Witdraw::class, 'index'])->name('witdraw.admin');
                Route::get('/reject/{id}', [App\Http\Controllers\Admin\Witdraw::class, 'reject'])->name('witdraw.reject.admin');
                Route::get('/accept/{id}', [App\Http\Controllers\Admin\Witdraw::class, 'accept'])->name('witdraw.accept.admin');

                Route::prefix('usdt')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\Witdraw::class, 'usdt'])->name('witdraw.admin.usdt');
                    Route::get('/reject/{id}', [App\Http\Controllers\Admin\Witdraw::class, 'rejectUsdt'])->name('witdraw.reject.admin.usdt');
                    Route::get('/accept/{id}', [App\Http\Controllers\Admin\Witdraw::class, 'acceptUsdt'])->name('witdraw.accept.admin.usdt');
                });

                Route::prefix('doge')->group(function () {
                    Route::get('/', [App\Http\Controllers\Admin\Witdraw::class, 'doge'])->name('witdraw.admin.doge');
                    Route::get('/reject/{id}', [App\Http\Controllers\Admin\Witdraw::class, 'rejectDoge'])->name('witdraw.reject.admin.doge');
                    Route::get('/accept/{id}', [App\Http\Controllers\Admin\Witdraw::class, 'acceptDoge'])->name('witdraw.accept.admin.doge');
                });
            });
        });
    });
});
