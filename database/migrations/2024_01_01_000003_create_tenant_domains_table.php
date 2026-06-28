<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_domains', function (Blueprint $table) {
            $table->id();
            $table->string('subdomain')->nullable()->index();
            $table->string('domain')->nullable()->index();
            $table->string('tenant_type');
            $table->unsignedBigInteger('tenant_id');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['tenant_type', 'tenant_id']);

            // Each subdomain and each full domain must be globally unique
            $table->unique('subdomain');
            $table->unique('domain');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_domains');
    }
};
