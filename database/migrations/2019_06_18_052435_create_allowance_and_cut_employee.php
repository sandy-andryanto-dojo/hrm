<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllowanceAndCutEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_allowances', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('employee_id');
            $table->boolean('is_active')->default(false);
            $table->double('cost', 19, 2)->default(0); 
            $table->engine = 'InnoDB';
            $table->foreign('type_id')->references('id')->on('employee_allowance_type')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->primary(['type_id', 'employee_id']);
        });

        Schema::create('employee_cuts', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('employee_id');
            $table->boolean('is_active')->default(false);
            $table->double('cost', 19, 2)->default(0); 
            $table->engine = 'InnoDB';
            $table->foreign('type_id')->references('id')->on('employee_loss_type')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->primary(['type_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_cuts');
        Schema::dropIfExists('employee_allowances');
    }
}
