<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySocialMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_social_medias', function (Blueprint $table) {
            $table->bigIncrements('id')->unique('id');
            $table->string('title', 225);
            $table->string('icon', 50);
            $table->text('url');
            $table->unsignedBigInteger('company_id')->index('const_company_social_medias');
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
        Schema::dropIfExists('company_social_medias');
    }
}
