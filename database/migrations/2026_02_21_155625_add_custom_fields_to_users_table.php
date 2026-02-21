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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'consultant'])->default('consultant')->after('email');
            $table->string('phone', 20)->nullable()->after('role');
            $table->string('profile_photo')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('profile_photo');
            $table->string('headline', 100)->nullable()->after('bio');
            $table->foreignId('recruited_by')->nullable()->constrained('users')->after('headline');
            $table->string('invite_code', 50)->unique()->nullable()->after('recruited_by');
            $table->enum('status', ['active', 'suspended', 'cancelled'])->default('active')->after('invite_code');
            $table->timestamp('trial_ends_at')->nullable()->after('status');
            $table->timestamp('suspended_at')->nullable()->after('trial_ends_at');
            $table->timestamp('cancelled_at')->nullable()->after('suspended_at');
            $table->string('referral_code', 50)->unique()->nullable()->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'profile_photo', 'bio', 'headline',
                'recruited_by', 'invite_code', 'status', 'trial_ends_at',
                'suspended_at', 'cancelled_at', 'referral_code'
            ]);
        });
    }
};
