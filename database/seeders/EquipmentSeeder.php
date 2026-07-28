<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'ONT Unit',         'category' => 'Networking',     'quantity' => 12, 'status' => 'Available', 'notes' => 'Primary fiber termination units'],
            ['name' => 'IPTV Set-top Box', 'category' => 'Entertainment',  'quantity' => 25, 'status' => 'Available', 'notes' => 'Used for new account activation'],
            ['name' => 'Router Kit',       'category' => 'Networking',     'quantity' => 18, 'status' => 'In Use',    'notes' => 'Distributed with installation orders'],
        ];

        foreach ($items as $item) {
            DB::table('equipment')->insertOrIgnore(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
