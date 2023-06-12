<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    protected $with = ['customer'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot([
                'customer_id',
                'room_id',
//                'quantity',
            ])
            ->withTimestamps();
    }

//    public function scopeFilter($query, array $filters)
//    {
//        //todo filter
//        $query->when($filters['search'] ?? null, fn($query, $search) => $query->search($search));
//    }
//
//    public function scopeSearch($query, $s)
//    {
//        $query->where('name', 'like', "%$s%");
//    }
}
