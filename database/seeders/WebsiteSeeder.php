<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTimestamp = Carbon::now();

        DB::table('websites')->insert([
            [
                'name' => 'Example Website 1',
                'url' => 'https://www.example.com',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp,
            ],
            [
                'name' => 'Example Website 2',
                'url' => 'https://www.example2.com',
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp,
            ],
            // Add more website entries as needed
        ]);
    }
}
