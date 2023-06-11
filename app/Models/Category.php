<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name', 'extra_attributes'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeFilter($query, array $filters)
    {
        //todo filter
        $query->when($filters['search'] ?? null, fn($query, $search) => $query->search($search));
    }

    public function scopeSearch($query, $s)
    {
        $query->where('code', 'like', "%$s%")
            ->orWhere('name', 'like', "%$s%");
    }
}
