<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCompanySocialMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_social_medias', function (Blueprint $table) {
            $table->foreign(['company_id'], 'const_company_social_medias')->references(['id'])->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_social_medias', function (Blueprint $table) {
            $table->dropForeign('const_company_social_medias');
        });
    }
}
