<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToManageNewsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manage_news_categories', function (Blueprint $table) {
            $table->foreign(['category_id'], 'const_category_relation')->references(['id'])->on('news_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['news_id'], 'const_news_relation')->references(['id'])->on('news')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manage_news_categories', function (Blueprint $table) {
            $table->dropForeign('const_category_relation');
            $table->dropForeign('const_news_relation');
        });
    }
}
