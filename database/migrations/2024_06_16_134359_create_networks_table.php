<?php

use App\Models\Network;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            //balance
            $table->decimal('network_matching', 20, 3)->default('0');
            $table->decimal('boost_matching', 20, 3)->default('0');
            $table->decimal('network_boost', 20, 3)->default('0');
            //last claim
            $table->dateTime('date_network_matching')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('date_boost_matching')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('date_network_boost')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            //limit max claim
            $table->bigInteger('network_matching_limit')->default(0);
            $table->bigInteger('boost_matching_limit')->default(0);
            $table->bigInteger('network_boost_limit')->default(0);
            $table->timestamps();
        });
        Network::create([
            'user_id' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};
