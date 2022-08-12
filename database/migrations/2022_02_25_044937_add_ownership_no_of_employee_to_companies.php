<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnershipNoOfEmployeeToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_website')->nullable();
            $table->string('company_fb_page')->nullable();
            $table->string('ownership')->nullable();
            $table->string('no_of_employee')->nullable();
            $table->string('operating_since')->nullable();
            $table->longText('company_services')->nullable();
            $table->string('isocode1')->nullable();
            $table->string('dialcode1')->nullable();
            $table->string('mobile_phone1')->nullable();
            $table->string('isocode2')->nullable();
            $table->string('dialcode2')->nullable();
            $table->string('mobile_phone2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
}
