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
            $table->foreignId('show_types_id')->constrained('show_types');
            $table->string('titolo');
            $table->text('descrizione');
            $table->unsignedTinyInteger('posti_disponibili');
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
