<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfertrains', function (Blueprint $table) {
            $table->id();
            $table->integer('train_id');
            $table->integer('user_id');
            $table->string('user_name');
            $table->date('date');
            $table->string('ride');
            $table->string('getoff');
            $table->integer('money');
            $table->string('visit');
            $table->integer('type');
            $table->integer('hantie');
            $table->integer('status');
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
        Schema::dropIfExists('transfertrains');
    }
}
