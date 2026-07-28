<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        $slots = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'];

        foreach ($slots as $slot) {
            DB::table('time_slots')->insertOrIgnore([
                'slot_time'    => $slot,
                'is_available' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
