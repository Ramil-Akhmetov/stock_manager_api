<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Room;
use App\Models\Transfer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $checkins = Transfer::factory(10)->create();

        foreach ($checkins as $checkin) {
            $items = Item::factory(5)->create();
            $checkin->items()->attach($items, [
                'note' => $faker->text(),
                'from_room_id' => Room::all()->random()->id,
                'to_room_id' => Room::all()->random()->id,
                'quantity' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
