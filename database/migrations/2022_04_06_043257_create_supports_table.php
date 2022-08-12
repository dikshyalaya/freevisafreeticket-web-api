<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ["support_category_id", "question", "slug", "answer", 'view'];
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_category_id')->nullable()->constrained('support_categories')->onDelete('cascade');
            $table->string('question');
            $table->string('slug');
            $table->longText('answer');
            $table->longText('answer_html');
            $table->integer('view')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supports');
    }
}
