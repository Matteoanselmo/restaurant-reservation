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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_type_id');
            $table->foreign('show_type_id')->references('id')->on('show_types');
            $table->string('titolo');
            $table->text('descrizione');
            $table->text('img_name')->nullable(true);
            $table->text('img_path')->nullable(true);
            $table->text('img_ext')->nullable(true);
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
        Schema::dropIfExists('artists');
    }
};
