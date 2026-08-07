<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'speed')) {
                $table->string('speed', 50)->nullable()->after('service_name');
            }
            if (!Schema::hasColumn('services', 'installation_fee')) {
                $table->decimal('installation_fee', 10, 2)->default(1000.00)->after('price');
            }
        });

        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'booking_ref')) {
                $table->string('booking_ref', 50)->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('appointments', 'is_walkin')) {
                $table->boolean('is_walkin')->default(false)->after('booking_ref');
            }
            if (!Schema::hasColumn('appointments', 'installation_address')) {
                $table->text('installation_address')->nullable()->after('preferred_time');
            }
            if (!Schema::hasColumn('appointments', 'valid_id_type')) {
                $table->string('valid_id_type', 50)->nullable()->after('valid_id');
            }
            if (!Schema::hasColumn('appointments', 'valid_id_number')) {
                $table->string('valid_id_number', 50)->nullable()->after('valid_id_type');
            }
            if (!Schema::hasColumn('appointments', 'installation_status')) {
                $table->enum('installation_status', ['Pending', 'Scheduled', 'Completed', 'Cancelled'])->default('Pending')->after('status');
            }
            if (!Schema::hasColumn('appointments', 'payment_status')) {
                $table->enum('payment_status', ['Pending Payment', 'Payment Confirmed', 'Cancelled'])->default('Pending Payment')->after('installation_status');
            }
            if (!Schema::hasColumn('appointments', 'payment_method')) {
                $table->string('payment_method', 50)->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('appointments', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)->default(0.00)->after('payment_method');
            }
            if (!Schema::hasColumn('appointments', 'amount_due')) {
                $table->decimal('amount_due', 10, 2)->default(0.00)->after('amount_paid');
            }
            if (!Schema::hasColumn('appointments', 'change_amount')) {
                $table->decimal('change_amount', 10, 2)->default(0.00)->after('amount_due');
            }
            if (!Schema::hasColumn('appointments', 'bank_name')) {
                $table->string('bank_name', 100)->nullable()->after('change_amount');
            }
            if (!Schema::hasColumn('appointments', 'reference_number')) {
                $table->string('reference_number', 100)->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('appointments', 'due_date')) {
                $table->date('due_date')->nullable()->after('reference_number');
            }
            if (!Schema::hasColumn('appointments', 'payment_date')) {
                $table->dateTime('payment_date')->nullable()->after('due_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['speed', 'installation_fee']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'booking_ref', 'is_walkin', 'installation_address',
                'valid_id_type', 'valid_id_number', 'installation_status',
                'payment_status', 'payment_method', 'amount_paid',
                'amount_due', 'change_amount', 'bank_name', 'reference_number',
                'due_date', 'payment_date'
            ]);
        });
    }
};
