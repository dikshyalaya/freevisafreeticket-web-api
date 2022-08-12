<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployesJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_job_categories', function (Blueprint $table) {
            $table->foreign(['job_category_id'], 'const_e_job_categories_relation')->references(['id'])->on('job_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['employ_id'], 'const_employ_relation')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_job_categories', function (Blueprint $table) {
            $table->dropForeign('const_e_job_categories_relation');
            $table->dropForeign('const_employ_relation');
        });
    }
}
