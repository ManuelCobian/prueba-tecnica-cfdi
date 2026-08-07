<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ca_states', function (Blueprint $table) {

            $table->id();
            $table->char('cve_ent', 2)->unique();
            $table->string('name', 80);
            $table->string('abbreviation', 10);
            $table->unsignedBigInteger('population_total')->default(0);
            $table->unsignedBigInteger('population_female')->default(0);
            $table->unsignedBigInteger('population_male')->default(0);
            $table->unsignedBigInteger('inhabited_houses')->default(0);
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("update_at")->useCurrent()->useCurrentOnUpdate();
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_states');
    }
};
