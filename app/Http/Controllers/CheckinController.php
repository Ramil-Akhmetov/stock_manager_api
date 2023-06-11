<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkin\StoreCheckinRequest;
use App\Http\Requests\Checkin\UpdateCheckinRequest;
use App\Http\Resources\Confirmation\CheckinCollection;
use App\Http\Resources\Confirmation\CheckinResource;
use App\Models\Checkin;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:checkins.create'], ['only' => ['store']]);
        $this->middleware(['permission:checkins.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:checkins.update'], ['only' => ['update']]);
        $this->middleware(['permission:checkins.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $filters = $request->all('search');
        $checkins = checkin::paginate();
        return new CheckinCollection($checkins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckinRequest $request)
    {
        $validated = $request->validated();
        $validated += [
            'user_id' => $request->user()->id,
        ];
        $checkin = checkin::create($validated);
        return new CheckinResource($checkin);
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkin $checkin)
    {
        return new CheckinResource($checkin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecheckinRequest $request, Checkin $checkin)
    {
        $checkin->update($request->validated());
        return new CheckinResource($checkin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkin $checkin)
    {
        $checkin->delete();
    }
}