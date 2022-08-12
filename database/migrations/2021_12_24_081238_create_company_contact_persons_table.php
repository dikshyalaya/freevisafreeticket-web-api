<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyContactPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_contact_persons', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->string('name', 50);
            $table->string('email', 50)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('position', 50)->nullable();
            $table->unsignedBigInteger('company_id')->index('company_contact_persons');
            $table->text('avatar');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
//            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_contact_persons');
    }
}
