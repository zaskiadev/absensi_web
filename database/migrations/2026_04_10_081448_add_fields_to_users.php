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
            //
            $table->string('phone')->nullable()->after('password');
            $table->string('emloyee_id')
                ->storedAs("CONCAT('U', LPAD(id, 4, '0'))")
                ->unique()->nullable()->after('phone');
            $table->enum('role',['admin', 'employee', 'HRM', 'HOD', 'GM'])->default('employee')->after('emloyee_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['phone', 'emloyee_id', 'role']);
            $table->dropSoftDeletes();
        });
    }
};
