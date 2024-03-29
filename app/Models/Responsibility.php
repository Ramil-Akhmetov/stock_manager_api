<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Responsibility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['start_date', 'end_date', 'user_id', 'room_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    public $casts = ['extra_attributes' => SchemalessAttributes::class];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
