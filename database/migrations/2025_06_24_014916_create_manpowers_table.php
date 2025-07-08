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
        Schema::create('manpowers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Designation::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Scenario::class)->constrained()->cascadeOnDelete();
            $table->decimal('rate_per_day', 10, 2);
            $table->integer('no_of_people');
            $table->integer('total_day');
            $table->string('remark')->nullable();
            $table->decimal('total_cost', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manpowers');
    }
};
