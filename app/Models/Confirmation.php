<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Confirmation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['item_id', 'quantity', 'user_id', 'extra_attributes'];

    protected $hidden = ['deleted_at'];

    public $casts = ['extra_attributes' => SchemalessAttributes::class];

    public function scopeWithExtraAttributes()
    {
        return $this->extra_attributes->modelScope();
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
