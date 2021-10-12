<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entity')->nullable();
            $table->string('name')->nullable();
            $table->string('code1')->nullable();
            $table->string('code2')->nullable();
            $table->string('minor_unit')->nullable();
            $table->string('withdraw_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('holidays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->date('date_holiday')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('postal_code')->nullable();
            $table->longText('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_folder')->default(false);
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->string('type')->nullable();
            $table->integer('size')->default(0);
            $table->string('model_name')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('model_id')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('parent_id')->references('id')->on('attachments')->onDelete('cascade');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('setting_name')->unique();
            $table->string('setting_slug')->unique();
            $table->longText('setting_value')->nullable();
            $table->integer('setting_group')->default(0);
            $table->integer('setting_type')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('iso_code')->nullable();
            $table->string('lang_code')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('capital_city_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::create('regencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('province_code')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->string('regency_code')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('district_code')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });

        Schema::create('messages_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_id')->nullable();
            $table->unsignedBigInteger('to_id')->nullable();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('messages_status')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('messages_status');
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('holidays');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('currencies');
    }
}
