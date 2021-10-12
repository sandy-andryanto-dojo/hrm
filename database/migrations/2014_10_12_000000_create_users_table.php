<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->boolean('email_confirm')->default(false);
            $table->boolean('phone_confirm')->default(false);
            $table->boolean('is_root')->default(false);
            $table->string('session_id')->nullable();
            $table->longtext('access_groups')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('users_genders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('users_blood_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('users_marital_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('users_Identity_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('users_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('tax_number')->nullable(); // NPWP
            $table->string('medical_number')->nullable(); // BPJS
            $table->string('family_number')->nullable(); // NO KK
            $table->string('nick_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->boolean('has_child')->default(false);
            $table->integer('total_child')->default(0);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('blood_id')->nullable();
            $table->unsignedBigInteger('identity_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->text('about_me')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('users_genders')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('users_marital_status')->onDelete('cascade');
            $table->foreign('blood_id')->references('id')->on('users_blood_types')->onDelete('cascade');
            $table->foreign('identity_id')->references('id')->on('users_Identity_types')->onDelete('cascade');
        });

        Schema::create('users_confirm', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('token');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_confirm');
        Schema::dropIfExists('users_profile');
        Schema::dropIfExists('users_Identity_types');
        Schema::dropIfExists('users_marital_status');
        Schema::dropIfExists('users_blood_types');
        Schema::dropIfExists('users_genders');
        Schema::dropIfExists('users');
    }
}
