<?php

namespace Database\Seeders;

use App\Models\Checkin;
use App\Models\Item;
use App\Models\Room;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $checkins = Checkin::factory(10)->create();

        foreach ($checkins as $checkin) {
            $items = Item::factory(5)->create();
            $checkin->items()->attach($items, [
                'supplier_id' => Supplier::all()->random()->id,
                'room_id' => Room::all()->random()->id,
                'quantity' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
