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
        Schema::create('employee_school_class', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 15);
            $table->string('school_class_id', 15);
            $table->unique(['employee_id', 'school_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_school_class');
    }
};
