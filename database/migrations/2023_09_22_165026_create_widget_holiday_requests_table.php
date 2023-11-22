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
        Schema::create('widget_holiday_requests', function (Blueprint $table) {
            $table->id();
            $table->string('google_id');
            $table->string('manager_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable()->comment('paid vacation, unpaid leave, sick leave, other');
            $table->string('period')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->bigInteger('parent')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_holiday_requests');
    }
};
