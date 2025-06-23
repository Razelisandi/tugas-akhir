<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cv_data', function (Blueprint $table) {
            $table->id(); // <-- tambahkan baris ini jika belum ada
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('personal_name')->nullable();
            $table->text('personal_last_education')->nullable();
            $table->text('personal_organization_history')->nullable();
            $table->text('personal_achievement_history')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_data');
    }
};
