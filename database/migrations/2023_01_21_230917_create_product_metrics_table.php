<?php

use App\Models\Project;
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
        Schema::create('product_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->date('launch_date');
            $table->unsignedSmallInteger('expected_competitors');
            $table->unsignedSmallInteger('order_of_entry');
            $table->float('cogs', 5, 2);
            $table->bigInteger('development_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_metrics');
    }
};
