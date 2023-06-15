<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, LogActivity;

    protected $fillable = ['name', 'surname', 'patronymic', 'email', 'password', 'photo'];

    protected $hidden = ['password', 'remember_token', 'email_verified_at', 'deleted_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'extra_attributes' => SchemalessAttributes::class,
    ];

    protected $with = ['roles:id,name'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept(['password'])
            ->logOnlyDirty();
    }

    //region Relationships
    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class);
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
            ->orWhere('email', 'like', "%$s%");
    }
}
