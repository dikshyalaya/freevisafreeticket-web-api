<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->string('title', 225);
            $table->text('short_description')->nullable();
            $table->text('body');
            $table->text('html_content')->nullable();
            $table->text('feature_img');
            $table->string('seo_title', 225);
            $table->text('seo_description');
            $table->text('seo_keywords');
            $table->string('slug', 225)->nullable();
            $table->tinyInteger('is_active')->default(1)->nullable();
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
        Schema::dropIfExists('news');
    }
}
