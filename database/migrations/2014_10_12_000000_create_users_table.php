<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('contact_no')->nullable();

            $table->string('lrn')->nullable();
            $table->string('lname')->nullable();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('suffix', 20)->nullable();
            $table->string('sex', 20)->nullable();
            $table->date('bdate')->nullable();
            $table->string('age', 10)->nullable();
            $table->string('birthplace')->nullable();
            $table->string('mother_tongue')->nullable();

            $table->tinyInteger('is_indigenous')->default(0);
            $table->string('if_yes_indigenous')->nullable();
            $table->tinyInteger('is_4ps')->default(0);
            $table->string('household_4ps_id_no')->nullable();
            
            $table->string('current_province')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_barangay')->nullable();
            $table->string('current_street')->nullable();
            $table->string('current_zipcode', 15)->nullable();

            $table->string('permanent_province')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_barangay')->nullable();
            $table->string('permanent_street')->nullable();
            $table->string('permanent_zipcode', 15)->nullable();


            $table->string('father_lname')->nullable();
            $table->string('father_fname')->nullable();
            $table->string('father_mname')->nullable();
            $table->string('father_contact_no')->nullable();

            $table->string('mother_maiden_lname')->nullable();
            $table->string('mother_maiden_fname')->nullable();
            $table->string('mother_maiden_mname')->nullable();
            $table->string('mother_maiden_contact_no')->nullable();
            
            $table->string('guardian_lname')->nullable();
            $table->string('guardian_fname')->nullable();
            $table->string('guardian_mname')->nullable();
            $table->string('guardian_contact_no')->nullable();

            $table->string('role')->nullable();
            $table->timestamp('email_verified_at')->nullable();
         
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
