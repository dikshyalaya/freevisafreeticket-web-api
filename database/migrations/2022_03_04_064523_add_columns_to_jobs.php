<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('country_salary')->nullable();
            $table->string('nepali_salary')->nullable();
            $table->integer('no_of_male')->nullable();
            $table->integer('no_of_female')->nullable();
            $table->integer('any_gender')->nullable();
            $table->integer('working_hours')->nullable();
            $table->integer('working_days')->nullable();
            $table->integer('contract_year')->nullable();
            $table->integer('contract_month')->nullable();
            $table->longText('contract_description')->nullable();
            $table->integer('min_experience')->nullable();
            $table->integer('max_experience')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->string('skills')->nullable();
            $table->longText('requirement_intro')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('benefit_intro')->nullable();
            $table->tinyInteger('accomodation')->default(0)->nullable();
            $table->tinyInteger('food')->default(0)->nullable();
            $table->tinyInteger('annual_vacation')->default(0)->nullable();
            $table->tinyInteger('over_time')->default(0)->nullable();
            $table->string('pictures')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
