<?php

use App\Models\Bonus;
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
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bonus');
            $table->decimal('percentage', 8, 3);
            $table->timestamps();
        });

        $data = [
            [
                'bonus' => 10000,
                'percentage' => 0.01,
            ],
            [
                'bonus' => 30000,
                'percentage' => 0.025,
            ],
            [
                'bonus' => 90000,
                'percentage' => 0.04,
            ],
            [
                'bonus' => 200000,
                'percentage' => 0.06,
            ],
            [
                'bonus' => 500000,
                'percentage' => 0.08,
            ],
            [
                'bonus' => 900000,
                'percentage' => 0.12,
            ],
            
        ];

        foreach ($data as $key => $value) {
            Bonus::create($value);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonuses');
    }
};
