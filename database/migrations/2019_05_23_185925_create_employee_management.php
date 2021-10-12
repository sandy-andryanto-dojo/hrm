<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Pekerjaan
        Schema::create('employee_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Posisi Karyawan
        Schema::create('employee_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->double('hour_salary', 19, 2)->default(0);
            $table->double('month_salary', 19, 2)->default(0);
            $table->string('level')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Divisi Karyawan
        Schema::create('employee_divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('superior_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('superior_id')->references('id')->on('users')->onDelete('cascade');
        });

        

        // Jenis Karyawan
        Schema::create('employee_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Karyawan
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->string('employee_number')->nullable();
            $table->date('join_date')->nullable();
            $table->date('start_contract_date')->nullable();
            $table->date('end_contract_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_blacklist')->default(false);
            $table->longtext('token')->nullable();
            $table->longtext('finger_print')->nullable();
            $table->string('rank')->nullable();
            $table->double('weight', 19, 2)->default(0);
            $table->double('height', 19, 2)->default(0);
            $table->boolean('use_lens')->default(false);
            $table->boolean('retirement')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('employee_type')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('employee_positions')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('employee_divisions')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('employee_jobs')->onDelete('cascade');
        });

        // Jenis Cuti
        Schema::create('employee_annual_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

         // Jenis Tunjangan
         Schema::create('employee_allowance_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Jenis Potongan
        Schema::create('employee_loss_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Absensi
        Schema::create('employee_absence', function (Blueprint $table) {
            $table->date('absence_date');
            $table->unsignedBigInteger('employee_id');
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
            $table->integer('total')->default(0);
            $table->integer('status')->default(0);
            $table->integer('month')->default(0);
            $table->integer('year')->default(0);
            $table->longtext('notes')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('is_aprroved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->primary(['absence_date', 'employee_id']);
        });

        // Sakit
        Schema::create('employee_medical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('total_days', 19, 2)->default(0); 
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Cuti
        Schema::create('employee_annual', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('superior_id')->nullable();
            $table->date('request_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('type_id')->references('id')->on('employee_annual_type')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('superior_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Lembur
        Schema::create('employee_over_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('superior_id')->nullable();
            $table->date('request_date')->nullable();
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('superior_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Perjalanan Dinas atau tugas keluar kota
        Schema::create('employee_travel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('superior_id')->nullable();
            $table->date('request_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_reimbursed')->default(false);
            $table->double('cost', 19, 2)->default(0);
            $table->integer('destination')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('superior_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Pinjaman Karyawan
        Schema::create('employee_loan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('superior_id')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->double('cost', 19, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('superior_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Penggajihan
        Schema::create('employee_payroll', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('payment_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->double('total_absence', 19, 2)->default(0); 
            $table->double('basic_pay', 19, 2)->default(0); // Gaji Pokok = Gaji Per Jam x (total absen * jam kerja harian bisa 9 / 10 etx)
            $table->double('total_allowance', 19, 2)->default(0); // Tunjangan
            $table->double('total_bonus', 19, 2)->default(0); // Bonus
            $table->double('gross_salary', 19, 2)->default(0); // Gaji Kotor = Gaji Pokok + Tunjangan + Bonus
            $table->double('total_loss', 19, 2)->default(0); // Potongan
            $table->double('total_loan', 19, 2)->default(0); // Pinjaman
            $table->double('take_home_salary', 19, 2)->default(0); // Gaji Bersih = Gaji Kotor - (Potongan + Pinjaman)
            $table->integer('month')->default(0);
            $table->integer('year')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Mutasi
        Schema::create('employee_mutations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('division_from_id')->nullable();
            $table->unsignedBigInteger('division_target_id')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Promosi / Kenaikan Pangkat
        Schema::create('employee_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('position_from_id')->nullable();
            $table->unsignedBigInteger('position_target_id')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Pensiun
        Schema::create('employee_retired', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->date('date_retired')->nullable();
            $table->longtext('reason')->nullable();
            $table->longtext('employee_notes')->nullable();
            $table->longtext('manager_notes')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });


        // Detail Penggajihan 
        Schema::create('employee_payroll_items', function (Blueprint $table) {
            $table->unsignedBigInteger('payroll_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->double('cost', 19, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('payroll_id')->references('id')->on('employee_payroll')->onDelete('cascade');
            $table->primary(['payroll_id', 'model_type','model_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_payroll_items');
        Schema::dropIfExists('employee_retired');
        Schema::dropIfExists('employee_promotions');
        Schema::dropIfExists('employee_mutations');
        Schema::dropIfExists('employee_payroll');
        Schema::dropIfExists('employee_loan');
        Schema::dropIfExists('employee_travel');
        Schema::dropIfExists('employee_over_time');
        Schema::dropIfExists('employee_annual');
        Schema::dropIfExists('employee_medical');
        Schema::dropIfExists('employee_absence');
        Schema::dropIfExists('employee_loss_type');
        Schema::dropIfExists('employee_allowance_type');
        Schema::dropIfExists('employee_annual_type');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_type');
        Schema::dropIfExists('employee_divisions');
        Schema::dropIfExists('employee_positions');
        Schema::dropIfExists('employee_jobs');
    }
}
