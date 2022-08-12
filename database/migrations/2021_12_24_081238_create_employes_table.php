<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->date('dob')->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('marital_status', 50)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('tel_phone', 20)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->unsignedBigInteger('exprience_id')->nullable();
            $table->unsignedBigInteger('user_id')->index('const_user_employ');
            $table->unsignedBigInteger('functional_area_id')->nullable();
            $table->integer('expected_salary')->nullable();
            $table->integer('salary_currency')->nullable();
            $table->string('address', 50)->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_verified')->default(0);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->text('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employes');
    }
}
