<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learners', function (Blueprint $table) {
            $table->id('learner_id');
 

            $table->string('grade_level')->nullable();
            $table->tinyInteger('is_returnee')->default(0);

            $table->string('psa_cert')->nullable();
            $table->string('lrn', 30)->nullable();
            $table->string('lname', 50)->nullable();
            $table->string('fname', 50)->nullable();
            $table->string('mname', 50)->nullable();
            $table->string('extension', 10)->nullable();
            $table->string('sex', 10)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace', 100)->nullable();
            $table->string('age', 3)->nullable();
            
            $table->string('mother_tongue', 100)->nullable();
            $table->tinyInteger('is_indigenous')->default(0);
            $table->string('if_yes_indigenous')->nullable();
            $table->string('is_4ps')->nullable();
            $table->string('household_4ps_id_no')->nullable();

            $table->string('current_country')->nullable();
            $table->string('current_province')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_barangay')->nullable();
            $table->string('current_street')->nullable();
            $table->string('current_zipcode')->nullable();

            $table->string('permanent_country')->nullable();
            $table->string('permanent_province')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_barangay')->nullable();
            $table->string('permanent_street')->nullable();
            $table->string('permanent_zipcode')->nullable();

            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();

            //father
            $table->string('father_lname')->nullable();
            $table->string('father_fname')->nullable();
            $table->string('father_mname')->nullable();
            $table->string('father_extension')->nullable();
            $table->string('father_contact_no')->nullable();

            //mother
            $table->string('mother_maiden_lname')->nullable();
            $table->string('mother_maiden_fname')->nullable();
            $table->string('mother_maiden_mname')->nullable();
            $table->string('mother_maiden_contact_no')->nullable();

            $table->string('guardian_lname')->nullable();
            $table->string('guardian_fname')->nullable();
            $table->string('guardian_mname')->nullable();
            $table->string('guardian_extension')->nullable();
            $table->string('guardian_contact_no')->nullable();


            $table->string('last_grade_level_completed', 30)->nullable();
            $table->string('last_school_year_completed', 30)->nullable();
            $table->string('last_school_attended', 100)->nullable();
            $table->string('last_schoold_id', 30)->nullable();

            $table->unsignedBigInteger('semester_id')->default(0);
            $table->string('senior_high_school_id', 30)->nullable();

            $table->unsignedBigInteger('track_id')->default(0);
            $table->unsignedBigInteger('strand_id')->default(0);

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
        Schema::dropIfExists('learners');
    }
}
