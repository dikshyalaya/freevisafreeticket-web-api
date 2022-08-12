<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employ_id")->onDelete('cascade')->constrained('employes')->nullable();
            $table->foreignId("company_id")->onDelete('cascade')->constrained('companies')->nullable();
            $table->dateTime('followed_time')->nullable();
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
        Schema::dropIfExists('company_followers');
    }
}
