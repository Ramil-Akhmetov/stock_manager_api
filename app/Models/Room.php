<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Room extends Model
{
    use HasFactory, SoftDeletes, LogActivity;

    protected $fillable = ['name', 'number', 'user_id', 'room_type_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    protected $with = ['room_type'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    //region Relationships
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function transfers()
    {
        return $this->belongsTo(Transfer::class);
    }

    //endregion

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search']) {
            $query->search($filters['search']);
        }
    }

    public function scopeSearch($query, $s)
    {
        $query->where('name', 'like', "%$s%");
    }
}
