<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_superuser')->default(0); // کاربری که به همه چیز دسترسی دارد
            $table->boolean('is_staff')->default(0);  // کارمند با اجازه دسترسی محدود
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('tow_factor_type',['off','sms']);
            $table->string('phone_number')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
