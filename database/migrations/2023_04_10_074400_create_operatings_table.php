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
        Schema::create('operatings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Project::class);
            $table->date('year');
            $table->unsignedBigInteger('development_cost');
            $table->unsignedBigInteger('litigation_cost');
            $table->unsignedBigInteger('other_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operatings');
    }
};
