<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'surname', 'patronymic', 'phone', 'email', 'company', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search']) {
            $query->search($filters['search']);
        }
    }

    public function scopeSearch($query, $s)
    {
        $query->where('name', 'like', "%$s%")
            ->orWhere('surname', 'like', "%$s%")
            ->orWhere('patronymic', 'like', "%$s%")
            ->orWhere('phone', 'like', "%$s%")
            ->orWhere('email', 'like', "%$s%")
            ->orWhere('company', 'like', "%$s%");
    }
}
