<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Dell XPS 15
            $table->enum('type', ['laptop', 'printer', 'scanner']);
            $table->enum('status', ['available', 'on_loan', 'under_maintenance', 'pending_inspection']);
            $table->enum('condition_at_checkout', ['excellent', 'good', 'damaged'])->nullable();
            $table->date('purchase_date');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('devices'); }
};
