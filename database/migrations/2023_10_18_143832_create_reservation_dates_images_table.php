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
    Schema::create('reservation_dates_images', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('ext');
        $table->string('path');
        $table->unsignedBigInteger('reservation_date_id');
        $table->foreign('reservation_date_id')
            ->references('id')
            ->on('reservation_dates')
            ->onDelete('cascade');
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
        Schema::table('reservation_dates_images', function (Blueprint $table) {
            //
        });
    }
};
