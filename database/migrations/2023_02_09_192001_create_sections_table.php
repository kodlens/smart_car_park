<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id('section_id');

            $table->unsignedBigInteger('track_id');
            $table->foreign('track_id')->references('track_id')->on('tracks')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('strand_id');
            $table->foreign('strand_id')->references('strand_id')->on('strands')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('max')->default(0);

            $table->string('section')->nullable();
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
        Schema::dropIfExists('sections');
    }
}
