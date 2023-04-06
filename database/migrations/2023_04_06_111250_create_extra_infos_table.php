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
        Schema::create('extra_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Project::class);
            $table->date('year');
            $table->unsignedSmallInteger('expected_competitors')->nullable();
            $table->unsignedSmallInteger('order_of_entry')->nullable();
            $table->unique(['project_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_infos');
    }
};
