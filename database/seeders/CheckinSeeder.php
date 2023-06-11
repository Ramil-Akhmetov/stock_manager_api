<?php

namespace Database\Seeders;

use App\Models\Checkin;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::factory(5)->create();
        Checkin::factory(10)->hasAttached($items)->create();
    }
}
