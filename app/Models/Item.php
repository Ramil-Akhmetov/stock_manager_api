<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name', 'quantity', 'unit', 'photo', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    protected $with = ['category', 'type', 'group', 'room'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function checkins()
    {
        return $this->belongsToMany(Checkin::class)
            ->withPivot([
                'supplier_id',
                'room_id',
                'quantity',
            ])
            ->withTimestamps();
    }

    public function checkouts()
    {
        return $this->belongsToMany(Checkout::class)
            ->withPivot([
                'customer_id',
//                'room_id',
//                'quantity',
            ])
            ->withTimestamps();
    }

    public function transfers()
    {
        return $this->belongsToMany(Transfer::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function confirmations()
    {
        return $this->hasMany(Confirmation::class);
    }

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search']) {
            $query->search($filters['search']);
        }
    }

    public function scopeSearch($query, $s)
    {
        $query->where('code', 'like', "%$s%")
            ->orWhere('name', 'like', "%$s%");
    }
}
