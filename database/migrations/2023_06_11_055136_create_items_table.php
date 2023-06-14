<?php

use App\Models\Category;
use App\Models\Group;
use App\Models\Room;
use App\Models\Type;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedFloat('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->text('photo')->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(Type::class)->nullable();
            $table->foreignIdFor(Group::class)->nullable();
            $table->foreignIdFor(Room::class);
            $table->schemalessAttributes('extra_attributes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
