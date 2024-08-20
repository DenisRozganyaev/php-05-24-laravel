<?php

namespace App\Http\Controllers\Callbacks;

use App\Http\Controllers\Controller;
use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\NotAllRequiredAttributesException;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\ResponseOutdatedException;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\SignatureException;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Exception;
use Illuminate\Http\Request;

class JoinTelegramController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(TelegramLoginAuth $telegramLoginAuth, Request $request)
    {
        auth()->user()->update(['telegram_id' => $request->get('id')]);
        return redirect()->back();
    }
}
