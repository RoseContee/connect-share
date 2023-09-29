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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('google_id');
            $table->string('email')->unique();
            $table->string('given_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('avatar')->nullable();
            $table->string('org_title')->nullable();
            $table->string('org_department')->nullable();
            $table->string('drive_usage', 20)->nullable();
            $table->string('gmail_usage', 20)->nullable();
            $table->string('photos_usage', 20)->nullable();
            $table->string('manager_id')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('domain');
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
