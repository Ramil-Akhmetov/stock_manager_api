<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = ['name', 'surname', 'patronymic', 'email', 'password'];

    protected $hidden = ['password', 'remember_token', 'email_verified_at', 'deleted_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'extra_attributes' => SchemalessAttributes::class,
    ];

    protected $with = ['roles:id,name'];

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
        $query->where('name', 'like', "%$s%")
            ->orWhere('surname', 'like', "%$s%")
            ->orWhere('patronymic', 'like', "%$s%")
            ->orWhere('phone', 'like', "%$s%")
            ->orWhere('email', 'like', "%$s%");
    }
}
