<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // New columns.
        Schema::table('organisations', function (Blueprint $table) {
            $table->string('sub_domain')->nullable()->unique()->after('slug');
            $table->string('fav_icon')->nullable()->after('logo');
            $table->unsignedBigInteger('login_template_id')->nullable()->after('fav_icon');
            $table->unsignedBigInteger('dashboard_template_id')->nullable()->after('login_template_id');
            $table->index('login_template_id');
            $table->index('dashboard_template_id');
        });

        // Drop legacy / unused columns.
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn([
                'login_template',
                'dashboard_template',
                'database_name',
                'is_email_sms',
                'vendor_type',
                'sms_vendor',
                'payment_gateway_vendor',
                'must_reset_password',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropIndex(['login_template_id']);
            $table->dropIndex(['dashboard_template_id']);
            $table->dropColumn([
                'sub_domain',
                'fav_icon',
                'login_template_id',
                'dashboard_template_id',
            ]);
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->string('login_template')->default('login-1');
            $table->string('dashboard_template')->default('dashboard-1');
            $table->string('database_name')->nullable();
            $table->string('is_email_sms')->nullable();
            $table->string('vendor_type')->nullable();
            $table->string('sms_vendor')->nullable();
            $table->string('payment_gateway_vendor')->nullable();
            $table->boolean('must_reset_password')->default(true);
        });
    }
};
