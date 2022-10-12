<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToEmployeeEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_education', function (Blueprint $table) {
            //
            $table->string('institution_name', 255)->nullable();
            $table->string('institution_address', 255)->nullable();
            $table->string('completion_year', 10)->nullable();
            $table->string('score', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_education', function (Blueprint $table) {
            //
        });
    }
}
