<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Transfer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::factory(5)->create();
        Transfer::factory(10)->hasAttached($items)->create();
    }
}
