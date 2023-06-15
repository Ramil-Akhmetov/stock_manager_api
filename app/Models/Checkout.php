<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes, LogActivity;

    protected $fillable = ['note', 'user_id', 'customer_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    protected $with = ['items'];

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
        return $this->belongsToMany(Item::class)
            ->using(CheckoutItem::class)
            ->withPivot([
                'room_id',
                'quantity',
            ])
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
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
