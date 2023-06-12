<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['reason', 'user_id', 'from_room_id', 'to_room_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    protected $with = ['items'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeFilter($query, array $filters)
    {
        //todo filter
        $query->when($filters['search'] ?? null, fn($query, $search) => $query->search($search));
    }

    public function scopeSearch($query, $s)
    {
        $query->where('reason', 'like', "%$s%");
    }
}
