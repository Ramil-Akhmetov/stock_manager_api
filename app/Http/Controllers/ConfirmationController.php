<?php

namespace App\Http\Controllers;

use App\Http\Requests\Confirmaiton\StoreConfirmationRequest;
use App\Http\Requests\Confirmaiton\UpdateConfirmationRequest;
use App\Http\Resources\Confirmation\ConfirmationCollection;
use App\Http\Resources\Confirmation\ConfirmationResource;
use App\Models\Confirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConfirmationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:confirmations.create'], ['only' => ['store']]);
        $this->middleware(['permission:confirmations.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:confirmations.update'], ['only' => ['update']]);
        $this->middleware(['permission:confirmations.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $confirmations = Confirmation::paginate();
        return new ConfirmationCollection($confirmations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConfirmationRequest $request)
    {
        //todo update item info event
        $validated = $request->validated();
        $validated += [
            'user_id' => $request->user()->id,
        ];
        $confirmation = Confirmation::create($validated);
        return new ConfirmationResource($confirmation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Confirmation $confirmation)
    {
        return new ConfirmationResource($confirmation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConfirmationRequest $request, Confirmation $confirmation)
    {
        //todo update item info event
        $confirmation->update($request->validated());
        return new ConfirmationResource($confirmation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Confirmation $confirmation)
    {
        $confirmation->delete();
    }
}