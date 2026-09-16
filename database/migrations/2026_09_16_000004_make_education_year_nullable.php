<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Some qualifications (professional certifications, for example) have no year
 * on a CV, so the year becomes optional.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE education MODIFY `year` YEAR NULL');
        DB::statement('ALTER TABLE education MODIFY `achievement` LONGTEXT NULL');
    }

    public function down(): void
    {
        DB::statement("UPDATE education SET `year` = YEAR(CURDATE()) WHERE `year` IS NULL");
        DB::statement("UPDATE education SET `achievement` = '' WHERE `achievement` IS NULL");
        DB::statement('ALTER TABLE education MODIFY `year` YEAR NOT NULL');
        DB::statement('ALTER TABLE education MODIFY `achievement` LONGTEXT NOT NULL');
    }
};
