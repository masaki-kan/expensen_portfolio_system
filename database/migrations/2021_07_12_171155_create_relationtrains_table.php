<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationtrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationtrains', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('train_id');
            $table->timestamp('date');
            $table->string('line');
            $table->string('ride');
            $table->string('getoff');
            $table->string('money');
            $table->integer('type');
            $table->string('memo');
            $table->integer('hantei');
            $table->integer('list_order');
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
        Schema::dropIfExists('relationtrains');
    }
}
