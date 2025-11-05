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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('linkedin_url');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->enum('activity', ['active', 'moderate', 'inactive'])->default('moderate');
            $table->boolean('connected')->default(false);
            $table->boolean('is_favorite')->default(false);
            $table->timestamp('last_visited_at')->nullable();
            $table->date('next_follow_up')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('last_visited_at');
            $table->index('next_follow_up');
            $table->index('connected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
