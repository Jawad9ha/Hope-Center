<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained();
            $table->text('description');
            $table->foreignId('reported_by')->constrained('employees');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('damage_reports'); }
};