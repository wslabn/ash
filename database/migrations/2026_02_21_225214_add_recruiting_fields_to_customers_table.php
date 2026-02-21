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
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('recruiting_interest')->default(false)->after('notes');
            $table->foreignId('converted_to_user_id')->nullable()->constrained('users')->onDelete('set null')->after('recruiting_interest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['converted_to_user_id']);
            $table->dropColumn(['recruiting_interest', 'converted_to_user_id']);
        });
    }
};
