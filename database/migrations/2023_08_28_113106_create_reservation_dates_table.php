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
        Schema::create('reservation_dates', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->unsignedBigInteger('show_type_id');
            $table->foreign('show_type_id')->references('id')->on('show_types');
            $table->string('titolo');
            $table->text('descrizione');
            $table->float('prezzo', 5, 2);
            $table->enum('pranzo_cena', ['pranzo', 'cena']);
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
        Schema::dropIfExists('reservation_dates');
    }
};
