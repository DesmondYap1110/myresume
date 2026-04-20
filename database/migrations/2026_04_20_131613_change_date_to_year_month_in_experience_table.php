<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {

        // Step 1: expand column
        DB::statement("ALTER TABLE experience
            MODIFY start_date VARCHAR(10),
            MODIFY end_date VARCHAR(10)");

        // Step 2: convert data
        DB::statement("UPDATE experience
            SET start_date = DATE_FORMAT(start_date, '%Y-%m'),
                end_date   = DATE_FORMAT(end_date, '%Y-%m')");

        // Step 3: shrink column
        DB::statement("ALTER TABLE experience
            MODIFY start_date VARCHAR(7) NOT NULL,
            MODIFY end_date VARCHAR(7) NULL");
    }

    public function down(): void
    {
        // rollback (basic)
        Schema::table('experience', function (Blueprint $table) {
            $table->dropColumn('work_status');
        });
    }
};

