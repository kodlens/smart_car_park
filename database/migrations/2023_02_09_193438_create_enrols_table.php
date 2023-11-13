<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrols', function (Blueprint $table) {
            $table->id('enrol_id');

            $table->unsignedBigInteger('academic_year_id');
            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('grade_level')->nullable();
            $table->tinyInteger('is_returnee')->nullable();

            $table->unsignedBigInteger('learner_id');
            $table->foreign('learner_id')->references('learner_id')->on('learners')
                ->onUpdate('cascade')->onDelete('cascade');


            $table->unsignedBigInteger('semester_id')->default(0);
            $table->unsignedBigInteger('track_id')->default(0);
            $table->unsignedBigInteger('strand_id')->default(0);

            $table->date('date_enroled')->nullable();

            $table->unsignedBigInteger('section_id');
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
        Schema::dropIfExists('enrols');
    }
}
