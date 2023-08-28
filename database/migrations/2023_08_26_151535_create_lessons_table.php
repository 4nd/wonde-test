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
        Schema::create('lessons', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->dateTime('start_at')->index();
            $table->dateTime('end_at')->index();
            $table->string('period_id', 15)->nullable()->index();
            $table->string('school_class_id', 15)->nullable()->index();
            $table->string('employee_id', 15)->nullable()->index();
            $table->string('room_id', 15)->nullable()->index();
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
        Schema::dropIfExists('lessons');
    }
};
