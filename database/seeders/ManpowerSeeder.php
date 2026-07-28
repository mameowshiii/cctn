<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManpowerSeeder extends Seeder
{
    public function run(): void
    {
        $staff = [
            ['name' => 'John Dela Cruz',   'role' => 'Field Technician',  'availability' => 'Available', 'notes' => 'Handles installation jobs'],
            ['name' => 'Maria Santos',     'role' => 'Customer Support',   'availability' => 'Available', 'notes' => 'Handles follow-up calls'],
            ['name' => 'Rico Villanueva',  'role' => 'Operations Lead',    'availability' => 'On Duty',   'notes' => 'Coordinates maintenance schedules'],
        ];

        foreach ($staff as $member) {
            DB::table('manpower')->insertOrIgnore(array_merge($member, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
