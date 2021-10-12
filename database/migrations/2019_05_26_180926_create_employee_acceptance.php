<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAcceptance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Lowongan
        Schema::create('employee_vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->date('start_date')->nullable()->nullable();
            $table->date('end_date')->nullable()->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('location')->nullable();
            $table->longtext('info')->nullable();
            $table->longtext('history')->nullable();
            $table->longtext('profile')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->double('min_salary', 19, 2)->default(0); 
            $table->double('max_salary', 19, 2)->default(0); 
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('type_id')->references('id')->on('employee_type')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('employee_positions')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('employee_divisions')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('employee_jobs')->onDelete('cascade');
        });

        // Proses Rekrut
        Schema::create('employee_acceptance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vacancy_id')->nullable();
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->double('pskikotest_score', 19, 2)->default(0); 
            $table->double('technical_score', 19, 2)->default(0); 
            $table->double('healthy_score', 19, 2)->default(0); 
            $table->double('interview_score', 19, 2)->default(0); 
            $table->unsignedBigInteger('hrd_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->boolean('hrd_approved')->default(false);
            $table->boolean('manager_approved')->default(false);
            $table->text('hrd_notes')->nullable();
            $table->text('manager_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vacancy_id')->references('id')->on('employee_vacancies')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('employee_candidates')->onDelete('cascade');
            $table->foreign('hrd_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Setelah Diterima
        Schema::create('employee_accepted', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('acceptance_id')->nullable();
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('acceptance_id')->references('id')->on('employee_acceptance')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('employee_candidates')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->text('notes');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_accepted');
        Schema::dropIfExists('employee_acceptance');
        Schema::dropIfExists('employee_vacancies');
    }
}
