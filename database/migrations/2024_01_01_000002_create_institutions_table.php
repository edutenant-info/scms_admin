<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->foreignId('organisation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('institution_type_id')->constrained('institution_types');
            $table->foreignId('board_id')->constrained('boards');
            // dashboard_templates is created in a later migration; the FK is added
            // separately in add_dashboard_template_fk_to_institutions_table.
            $table->unsignedBigInteger('dashboard_template_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('mobile', 10);
            $table->string('password');
            $table->string('sub_domain')->nullable()->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('zonal_partner_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('fav_icon')->nullable();
            $table->string('database_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
