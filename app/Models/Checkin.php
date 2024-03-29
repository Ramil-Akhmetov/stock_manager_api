<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Checkin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['note', 'user_id', 'supplier_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    protected $with = ['items'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot([
                'room_id',
                'quantity',
            ])
            ->withTimestamps();
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search']) {
            $query->search($filters['search']);
        }
    }

    public function scopeSearch($query, $s)
    {
        $query->where('note', 'like', "%$s%");
    }
}
