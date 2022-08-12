<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployesSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_skills', function (Blueprint $table) {
            $table->foreign(['employ_id'], 'const_e_emp_id')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['skills_id'], 'const_e_skills_relation')->references(['id'])->on('skills')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_skills', function (Blueprint $table) {
            $table->dropForeign('const_e_emp_id');
            $table->dropForeign('const_e_skills_relation');
        });
    }
}
