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
        //todo filter
        $query->when($filters['search'] ?? null, fn($query, $search) => $query->search($search));
    }

    public function scopeSearch($query, $s)
    {
        $query->where(fn($q) => $q->where('code', 'like', "%$s%")->orWhere('name', 'like', "%$s%"));
    }
}
