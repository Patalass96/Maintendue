<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::table('users', function (Blueprint $table) {
          if (!Schema::hasColumn('users', 'is_verified')) {
            $table->boolean('is_verified')->default(false)->after('role');}

            if (!Schema::hasColumn('users', 'otp_code')) {
                $table->string('otp_code')->nullable()->after('password');
            }


            if (!Schema::hasColumn('users', 'otp_expires_at')) {
                $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            }

            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('is_verified');
            }
        });
    }

/**
 * Reverse the migrations.
 */
public function down(): void {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['is_verified', 'otp_code', 'otp_expires_at', 'verified_at']);
    });
}

};
