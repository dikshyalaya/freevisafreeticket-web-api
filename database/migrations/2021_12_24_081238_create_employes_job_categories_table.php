<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes_job_categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->unsignedBigInteger('employ_id')->index('const_employ_relation');
            $table->unsignedBigInteger('job_category_id')->index('const_e_job_categories_relation');
            $table->integer('order_by')->nullable();
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
        Schema::dropIfExists('employes_job_categories');
    }
}
