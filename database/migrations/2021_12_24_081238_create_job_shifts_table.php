<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_shifts', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->string('job_shift', 200)->nullable();
            $table->boolean('is_default')->nullable()->default(false);
            $table->boolean('is_active')->nullable();
            $table->integer('sort_order')->nullable()->default(99999);
            $table->string('lang', 10)->nullable()->default('en');
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
        Schema::dropIfExists('job_shifts');
    }
}
