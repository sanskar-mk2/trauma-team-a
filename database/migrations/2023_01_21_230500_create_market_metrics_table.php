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
        Schema::create('market_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->string('salt');
            $table->string('form');
            $table->string('evaluate_by');
            $table->string('brand_generic');
            $table->string('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_metrics');
    }
};
