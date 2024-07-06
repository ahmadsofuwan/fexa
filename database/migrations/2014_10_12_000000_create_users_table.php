<?php

use App\Http\Controllers\Helper\Help;
use App\Models\Network;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['admin', 'customer'])->default('customer');
            $table->string('username');
            $table->string('password');
            $table->string('phone');
            $table->string('wallet')->nullable();
            $table->decimal('saldo', 50, 3)->default('0');
            $table->decimal('usdt', 50, 3)->default('0');
            $table->decimal('doge', 50, 3)->default('0');
            $table->string('upline')->nullable();
            $table->string('otp')->nullable();
            $table->enum('status', ['active', 'nonactive'])->default("nonactive");
            $table->decimal('bonus', 20, 3)->default('0');
            $table->decimal('bonus_downline', 20, 3)->default('0');
            $table->decimal('staking_token', 20, 3)->default('0');
            $table->enum('bonus_active', ['active', 'nonactive'])->default("nonactive");
            $table->dateTime('last_bonus_claim')->nullable();
            $table->timestamps();
        });
        $user = new User;
        $user->role = 'admin';
        $user->username = 'admin';
        $user->phone = '6282178071169';
        $user->password = bcrypt('admin');
        $user->save();

        // $user = new User;
        // $user->role = 'customer';
        // $user->username = 'aaa';
        // $user->phone = '6282178071169';
        // $user->password = bcrypt('aaa');
        // $user->save();

        $user = new User;
        $user->role = 'customer';
        $user->username = 'user';
        $user->phone = '6282178071169';
        $user->password = bcrypt('user');
        $user->saldo = '2001';
        $user->usdt = '100000';
        $user->doge = '1000000';
        $user->wallet = 'DUDqhsWXvioz9TrWjC82UT4iYfmsZCct1U';
        // $user->upline = 2;
        $user->status = 'active';
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
