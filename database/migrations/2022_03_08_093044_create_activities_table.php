<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('topic_id')->nullable(false)->default(0);
            $table->bigInteger('created_by')->nullable(false)->default(0);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedInteger('participant_num')->nullable(false)->default(0);
            $table->string('remarks', 500)->nullable(false)->default('');
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
        Schema::dropIfExists('activities');
    }
};
