<?php

use App\Models\Rank;
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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rank');
            $table->timestamps();
        });

        $ranks = new Rank;
        $ranks->name = 'supervisor';
        $ranks->rank = '0';
        $ranks->save();
        $ranks = new Rank;
        $ranks->name = 'manager 1k';
        $ranks->rank = '5000';
        $ranks->save();
        $ranks = new Rank;
        $ranks->name = 'manager 5k';
        $ranks->rank = '10000';
        $ranks->save();
        $ranks = new Rank;
        $ranks->name = 'manager 10k';
        $ranks->rank = '100000';
        $ranks->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
    }
};
