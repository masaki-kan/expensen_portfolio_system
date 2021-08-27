<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expensens', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('date')->notnull();
            $table->string('subject')->notnull();
            $table->integer('money')->notnull();
            $table->text('image')->nullable();
            $table->string('reason');
            $table->integer('status');
            $table->integer('applicant_flag');
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
        Schema::dropIfExists('expensens');
    }
}
