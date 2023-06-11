<?php

namespace Database\Seeders;

use App\Models\Checkout;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheckoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::factory(5)->create();
        Checkout::factory(10)->hasAttached($items)->create();
    }
}
