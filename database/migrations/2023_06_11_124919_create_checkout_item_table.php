<?php

use App\Models\Checkout;
use App\Models\Item;
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
        Schema::create('checkout_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Checkout::class);
            $table->foreignIdFor(Item::class);
            $table->unsignedFloat('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_item');
    }
};
