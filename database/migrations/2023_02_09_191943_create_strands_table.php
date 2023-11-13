<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strands', function (Blueprint $table) {
            $table->id('strand_id');

            $table->unsignedBigInteger('track_id');
            $table->foreign('track_id')->references('track_id')->on('tracks')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('strand')->nullable();
            $table->string('strand_desc')->nullable();

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
        Schema::dropIfExists('strands');
    }
}
