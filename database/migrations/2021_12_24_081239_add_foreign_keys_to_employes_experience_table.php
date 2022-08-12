<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployesExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_experience', function (Blueprint $table) {
            $table->foreign(['employ_id'], 'const_ employes_relation')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['experiencelevels_id'], 'const_experience_relation')->references(['id'])->on('experiencelevels')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_experience', function (Blueprint $table) {
            $table->dropForeign('const_ employes_relation');
            $table->dropForeign('const_experience_relation');
        });
    }
}
