<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdJobCategoryIdJobTitleWorkingYearWorkingMonthToEmployesExperience extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_experience', function (Blueprint $table) {
            $table->bigInteger('country_id')->nullable();
            $table->bigInteger('job_category_id')->nullable();
//            $table->bigInteger('job_title_id')->nullable();
            $table->bigInteger('industry_id')->nullable();
            $table->string('working_year')->nullable();
            $table->string('working_month')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_experience', function (Blueprint $table) {
            //
        });
    }
}
