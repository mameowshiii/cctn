<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('account_number', 50)->nullable();
            $table->string('firstname', 50);
            $table->string('middlename', 50)->nullable();
            $table->string('lastname', 50);
            $table->date('birthdate')->nullable();
            $table->integer('age')->default(0);
            $table->string('place_of_birth', 255)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('civil_status', 20)->nullable();
            $table->string('address_barangay', 100)->nullable();
            $table->string('address_municipality', 100)->nullable();
            $table->string('address_province', 100)->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('profile_photo', 255)->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('verification_token', 64)->nullable();
            $table->string('reset_token', 64)->nullable();
            $table->dateTime('reset_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
