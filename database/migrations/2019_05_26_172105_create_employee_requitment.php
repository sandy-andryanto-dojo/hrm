<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeRequitment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Industri
        Schema::create('employee_industries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

         // Qualifikasi
         Schema::create('employee_education_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Spesialisasi
        Schema::create('employee_specliationations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Jenis Lampiran
        Schema::create('employee_attachemt_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_required')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        // Profil Kandidat Pegawai
        Schema::create('employee_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('identity_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('blood_id')->nullable();
            $table->unsignedBigInteger('identity_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('gender_id')->references('id')->on('users_genders')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('users_marital_status')->onDelete('cascade');
            $table->foreign('blood_id')->references('id')->on('users_blood_types')->onDelete('cascade');
            $table->foreign('identity_id')->references('id')->on('users_Identity_types')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        // Pengalaman Bekarja
        Schema::create('employee_experience', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->string('company_name')->nullable();
            $table->integer('month_start')->nullable();
            $table->integer('year_start')->nullable();
            $table->integer('month_end')->nullable();
            $table->integer('year_end')->nullable();
            $table->unsignedBigInteger('specliationation_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('sallary', 19, 2)->default(0); 
            $table->longtext('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('candidate_id')->references('id')->on('employee_candidates')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('employee_positions')->onDelete('cascade');
            $table->foreign('specliationation_id')->references('id')->on('employee_specliationations')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('employee_divisions')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('industry_id')->references('id')->on('employee_industries')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });

        // Riwayat Pendidikan
        Schema::create('employee_education', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('school_name')->nullable();
            $table->integer('month_start')->nullable();
            $table->integer('year_start')->nullable();
            $table->integer('month_end')->nullable();
            $table->integer('year_end')->nullable();
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('specliationation')->nullable();
            $table->string('department')->nullable();
            $table->string('regency_id')->nullable();
            $table->double('score', 19, 2)->default(0); 
            $table->double('scale', 19, 2)->default(0); 
            $table->longtext('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('candidate_id')->references('id')->on('employee_candidates')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('qualification_id')->references('id')->on('employee_education_qualifications')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        // Keterampilan
        Schema::create('employee_specialist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('level')->default(0); 
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('candidate_id')->references('id')->on('employee_candidates')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        // Keterampilan Bahasa
        Schema::create('employee_toefl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->integer('level')->default(0); 
            $table->double('write', 19, 2)->default(0); 
            $table->double('listen', 19, 2)->default(0); 
            $table->double('read', 19, 2)->default(0); 
            $table->double('score', 19, 2)->default(0); 
            $table->double('scale', 19, 2)->default(0); 
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('candidate_id')->references('id')->on('employee_candidates')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_toefl');
        Schema::dropIfExists('employee_specialist');
        Schema::dropIfExists('employee_education');
        Schema::dropIfExists('employee_experience');
        Schema::dropIfExists('employee_candidates');
        Schema::dropIfExists('employee_attachemt_type');
        Schema::dropIfExists('employee_specliationations');
        Schema::dropIfExists('employee_education_qualifications');
        Schema::dropIfExists('employee_industries');
    }
}
