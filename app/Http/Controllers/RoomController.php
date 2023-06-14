<?php

namespace App\Http\Controllers;

use App\Events\RoomEvent;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:rooms.create'], ['only' => ['store']]);
        $this->middleware(['permission:rooms.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:rooms.update'], ['only' => ['update']]);
        $this->middleware(['permission:rooms.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('search');
        $rooms = Room::filter($filters)->paginate();
        return new RoomCollection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $room = Room::create($request->validated());
        RoomEvent::dispatch($room, 'store');
        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $old_user_id = $room->user_id;
        $room->update($request->validated());
        RoomEvent::dispatch($room, 'update', $old_user_id);
        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
    }
}
