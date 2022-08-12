<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreign(['employ_id'], 'const_ja_employ_relation')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['job_id'], 'const_ja_job__relation')->references(['id'])->on('jobs')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign('const_ja_employ_relation');
            $table->dropForeign('const_ja_job__relation');
        });
    }
}
