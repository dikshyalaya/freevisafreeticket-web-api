<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_id')->nullable()->constrained('supports')->onDelete('cascade');
            $table->foreignId('support_type_id')->nullable()->constrained('support_types')->onDelete('cascade');
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
        Schema::dropIfExists('type_supports');
    }
}
