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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->tinyInteger('installed')->default(0);
            $table->string('home_banner_title')->nullable();
            $table->string('home_banner_image')->nullable();
            $table->boolean('hide_profile_banner')->default(false);
            $table->string('profile_banner_image')->nullable();
            $table->string('widgets')->nullable();
            $table->string('token')->nullable();
            $table->string('requested_email')->nullable();
            $table->string('notify_to')->nullable();
            $table->enum('status', ['pending', 'active', 'blocked'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
