<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployesEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_education', function (Blueprint $table) {
            $table->foreign(['employ_id'], 'consr_employes_relation')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['educationlevels_id'], 'const_education_relation')->references(['id'])->on('educationlevels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_education', function (Blueprint $table) {
            $table->dropForeign('consr_employes_relation');
            $table->dropForeign('const_education_relation');
        });
    }
}
