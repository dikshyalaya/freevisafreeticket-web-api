<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployesCvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes_cv', function (Blueprint $table) {
            $table->foreign(['employ_id'], 'const_employes_cv')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes_cv', function (Blueprint $table) {
            $table->dropForeign('const_employes_cv');
        });
    }
}
