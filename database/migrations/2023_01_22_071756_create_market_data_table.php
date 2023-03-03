<?php

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
        Schema::create('market_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Strength::class);
            $table->date('year');
            $table->bigInteger('sales');
            $table->bigInteger('volume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_data');
    }
};
