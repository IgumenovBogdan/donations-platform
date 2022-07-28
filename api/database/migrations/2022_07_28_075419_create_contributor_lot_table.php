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
        Schema::create('contributor_lot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contributor_id');
            $table->unsignedBigInteger('lot_id');
            $table->integer('total_sent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributor_lot');
    }
};
