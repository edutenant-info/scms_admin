<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('mobile', 20)->unique();
            $table->string('password');
            $table->string('logo')->nullable();
            $table->string('login_template')->default('login-1');
            $table->string('dashboard_template')->default('dashboard-1');
            $table->string('mou_document')->nullable();
            $table->date('po_date')->nullable();
            $table->date('po_effective_date')->nullable();
            $table->string('contract_period')->nullable();
            $table->string('database_name')->nullable();
            $table->boolean('is_2fa_enabled')->default(false);
            $table->string('is_email_sms')->nullable();
            $table->string('vendor_type')->nullable();
            $table->string('sms_vendor')->nullable();
            $table->string('payment_gateway_vendor')->nullable();
            $table->boolean('must_reset_password')->default(true);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
