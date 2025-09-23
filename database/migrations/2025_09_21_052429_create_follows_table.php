<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            // user yang melakukan follow
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            // user yang di-follow
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // 1 user tidak boleh follow user yang sama berkali-kali
            $table->unique(['follower_id', 'following_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
