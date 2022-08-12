<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->string('company_name', 50);
            $table->text('company_logo')->nullable();
            $table->text('company_cover')->nullable();
            $table->text('company_banner')->nullable();
            $table->unsignedBigInteger('user_id')->index('const_user_company');
            $table->string('company_phone', 15)->nullable();
            $table->string('company_email', 50);
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->text('company_details')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('company_address', 50)->nullable();
            $table->boolean('is_active')->default(1);
            $table->double('is_featured')->default(0);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
