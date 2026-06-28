<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_configs', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_type');
            $table->unsignedBigInteger('tenant_id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('cast')->default('string'); // string|integer|float|boolean|array|json|null
            $table->timestamps();

            $table->index(['tenant_type', 'tenant_id']);

            // One config key per tenant
            $table->unique(['tenant_type', 'tenant_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_configs');
    }
};
