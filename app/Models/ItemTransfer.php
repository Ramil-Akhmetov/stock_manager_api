<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemTransfer extends Pivot
{
    use LogActivity;

    public $incrementing = true;

    protected $fillable = ['item_id', 'transfer_id', 'room_id', 'quantity', 'reason'];

    protected $table = 'item_transfer';
}
