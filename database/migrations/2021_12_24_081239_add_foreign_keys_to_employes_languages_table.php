<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployesLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_languages', function (Blueprint $table) {
            $table->foreign(['employ_id'], 'const_el_employ_relation')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['language_id'], 'const_el_language_relation')->references(['id'])->on('languages')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_languages', function (Blueprint $table) {
            $table->dropForeign('const_el_employ_relation');
            $table->dropForeign('const_el_language_relation');
        });
    }
}
