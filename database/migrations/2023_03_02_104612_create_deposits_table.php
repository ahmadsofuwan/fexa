<?php

use App\Models\Deposit;
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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->integer('withdraw');
            $table->timestamps();
        });
        $deposit = new Deposit;
        $deposit->price = '10';
        $deposit->withdraw = 2;
        $deposit->save();

        $deposit = new Deposit;
        $deposit->price = '100';
        $deposit->withdraw = 4;
        $deposit->save();

        $deposit = new Deposit;
        $deposit->price = '500';
        $deposit->withdraw = 6;
        $deposit->save();

        $deposit = new Deposit;
        $deposit->price = '1000';
        $deposit->withdraw = 8;
        $deposit->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};
