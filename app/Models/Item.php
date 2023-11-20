<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Item extends Model
{
    use HasFactory, SoftDeletes, LogActivity;

    protected $fillable = ['code', 'name', 'quantity', 'unit', 'photo', 'category_id', 'type_id', 'group_id', 'room_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    protected $with = ['category', 'type', 'group', 'room'];

    //region Relationships
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
            ->using(CheckinItem::class)
            ->withPivot([
                'room_id',
                'quantity',
            ])
            ->withTimestamps();
    }

    public function checkouts()
    {
        return $this->belongsToMany(Checkout::class)
            ->using(CheckoutItem::class)
            ->withPivot([
                'room_id',
                'quantity',
            ])
            ->withTimestamps();
    }

    public function transfers()
    {
        return $this->belongsToMany(Transfer::class)
            ->using(ItemTransfer::class)
            ->withPivot([
                'room_id',
                'quantity',
            ])
            ->withTimestamps();
    }

    public function confirmations()
    {
        return $this->hasMany(Confirmation::class);
    }
    //endregion

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    //TODO filter
    public function scopeFilter($query, array $filters)
    {
        if ($filters['search']) {
            $query->search($filters['search']);
        }
        if ($filters['category_id']) {
            $query->where('category_id', $filters['category_id']);
        }
        if ($filters['type_id']) {
            $query->where('type_id', $filters['type_id']);
        }
    }

    public function scopeSearch($query, $s)
    {
        $query->where('code', 'like', "%$s%")
            ->orWhere('name', 'like', "%$s%");
    }
}
