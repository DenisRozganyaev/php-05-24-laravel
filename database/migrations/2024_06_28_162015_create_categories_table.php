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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // website.com/categories/4 => website.com/categories/mobile-phones
            $table->string('name')->unique();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->index(['parent_id']);
            $table->fullText(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['parent_id']);
            $table->dropFullText(['slug']);
        });
        Schema::dropIfExists('categories');
    }
};
