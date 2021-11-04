<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('my_class_id');
            $table->integer('total')->nullable();
            $table->integer('totalMark')->nullable();
            $table->string('s1')->nullable();
            $table->string('s2')->nullable();
            $table->integer('s3')->nullable();
            $table->string('s4')->nullable();
            $table->string('s5')->nullable();
            $table->string('sessID');
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
        Schema::dropIfExists('marks');
    }
}
