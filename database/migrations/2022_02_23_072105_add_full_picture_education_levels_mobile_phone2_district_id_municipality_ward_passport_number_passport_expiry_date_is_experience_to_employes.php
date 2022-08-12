<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullPictureEducationLevelsMobilePhone2DistrictIdMunicipalityWardPassportNumberPassportExpiryDateIsExperienceToEmployes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes', function (Blueprint $table) {
            $table->longText("full_picture")->nullable();
            $table->bigInteger('education_level_id')->nullable();
            $table->string('dob_in_bs')->nullable();
            $table->string('mobile_phone2')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->string('municipality')->nullable();
            $table->integer('ward')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_expiry_date')->nullable();
            $table->tinyInteger('is_experience')->nullable();
//            $table->longText('trainings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes', function (Blueprint $table) {
            //
        });
    }
}
