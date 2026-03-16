<?php

namespace App\Http\Controllers;

use App\Actions\CreateMessage;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreMessageRequest $request, Room $room, CreateMessage $createMessage) : RedirectResponse
    {
         $createMessage->execute($room, auth()->user(), $request->validated());

         return to_route("rooms.show", $room->id);


    }
}
