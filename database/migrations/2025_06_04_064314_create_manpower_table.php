<?php

use App\Models\Designation;
use App\Models\Scenario;
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
        Schema::create('manpower', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Designation::class);
            $table->foreignIdFor(Scenario::class);
            $table->decimal('rate_per_day', 8, 2);
            $table->integer('no_of_people');
            $table->integer('total_day');
            $table->decimal('total_cost', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manpower');
    }
};
