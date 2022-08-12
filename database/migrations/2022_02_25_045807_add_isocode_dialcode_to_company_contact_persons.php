<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsocodeDialcodeToCompanyContactPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_contact_persons', function (Blueprint $table) {
            $table->string('person_designation')->nullable();
            $table->string('isocode')->nullable();
            $table->string('dialcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_contact_persons', function (Blueprint $table) {
            //
        });
    }
}
