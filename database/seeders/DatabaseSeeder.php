<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'resources/sql/schema.sql';
        DB::unprepared(file_get_contents($path));

        $path = 'resources/sql/first_half.sql';
        DB::unprepared(file_get_contents($path));

        $path = 'resources/sql/second_half.sql';
        DB::unprepared(file_get_contents($path));

        $path = 'resources/sql/rest_sql.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Database seeded!');
    }
}
