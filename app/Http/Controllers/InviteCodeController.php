<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInviteCodeRequest;
use App\Http\Requests\UpdateInviteCodeRequest;
use App\Models\InviteCode;
use Illuminate\Support\Str;

class InviteCodeController extends Controller
{
    public static function generateCode()
    {
        do {
            $code = Str::random(10);
        } while (InviteCode::where('code', $code)->first());

        return $code;
    }
}
