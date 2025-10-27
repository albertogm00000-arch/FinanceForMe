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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained();
            $table->string('type'); // 'lent', 'borrowed'
            $table->string('person_name');
            $table->string('person_contact')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('remaining_amount', 15, 2);
            $table->text('description');
            $table->date('loan_date');
            $table->date('due_date')->nullable();
            $table->string('status')->default('active'); // 'active', 'paid', 'overdue'
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
