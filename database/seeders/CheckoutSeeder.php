<?php

namespace Database\Seeders;

use App\Models\Checkout;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CheckoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $checkins = Checkout::factory(10)->create();

        foreach ($checkins as $checkin) {
            $items = Item::factory(5)->create();
            $checkin->items()->attach($items, [
                'room_id' => Room::all()->random()->id,
                'quantity' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
