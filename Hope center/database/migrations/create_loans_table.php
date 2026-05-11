<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained();
        $table->foreignId('device_id')->constrained();
        $table->dateTime('loaned_at');
        $table->dateTime('returned_at')->nullable();
        $table->enum('status', ['active', 'pending_inspection', 'completed']);
        $table->text('inspection_notes')->nullable();
        $table->foreignId('inspected_by')->nullable()->constrained('employees');
        $table->enum('condition_at_checkout', ['excellent', 'good', 'damaged'])->nullable();
        $table->timestamps();
});
    }
    public function down(): void { Schema::dropIfExists('loans'); }
};