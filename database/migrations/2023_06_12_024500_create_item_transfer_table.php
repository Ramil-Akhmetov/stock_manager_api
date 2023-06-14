<?php

use App\Models\Item;
use App\Models\Room;
use App\Models\Transfer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_transfer', function (Blueprint $table) {
            $table->id();
            $table->string('reason')->nullable();
            $table->foreignIdFor(Transfer::class);
            $table->foreignIdFor(Item::class);
            $table->foreignIdFor(Room::class); //to_room_id
            $table->unsignedFloat('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_transfer');
    }
};
