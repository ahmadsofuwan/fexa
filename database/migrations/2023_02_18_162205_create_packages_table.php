<?php

use App\Models\Package;
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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('price');
            $table->bigInteger('stock')->default(100);
            $table->bigInteger('static_stock')->default(100);
            $table->bigInteger('hours')->default(0);
            $table->decimal('total_profit', 20, 2);
            $table->timestamps();
        });
        //gratis
        $data = [

            [
                'price' => 500,
                'hours' => 360,
                'total_profit' => 550
            ],
            [
                'price' => 1000,
                'hours' => 312,
                'total_profit' => 1100
            ],
            [
                'price' => 3000,
                'hours' => 264,
                'total_profit' => 3300
            ],
            [
                'price' => 5000,
                'hours' => 216,
                'total_profit' => 5500
            ],
            [
                'price' => 10000,
                'hours' => 168,
                'total_profit' => 11000
            ],
            [
                'price' => 50000,
                'hours' => 120,
                'total_profit' => 55000
            ],
            [
                'price' => 100000,
                'hours' => 72,
                'total_profit' => 110000
            ],
            [
                'price' => 500000,
                'hours' => 48,
                'total_profit' => 550000
            ],
            [
                'price' => 1000000,
                'hours' => 24,
                'total_profit' => 1100000
            ],

        ];
        foreach ($data as $key => $value) {
            Package::create($value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
