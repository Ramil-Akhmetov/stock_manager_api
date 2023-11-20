<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\StoreTransferRequest;
use App\Http\Requests\Transfer\UpdateTransferRequest;
use App\Http\Resources\Transfer\TransferCollection;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Item;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:transfers.create'], ['only' => ['store']]);
        $this->middleware(['permission:transfers.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:transfers.update'], ['only' => ['update']]);
        $this->middleware(['permission:transfers.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('search');
        $transfers = Transfer::filter($filters)->paginate();
        return new TransferCollection($transfers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        $validated = $request->validated();
        $validated += [
            'user_id' => $request->user()->id,
        ];

        //TODO maybe should use event
        $transfer = DB::transaction(function () use ($validated) {
            $transfer = Transfer::create($validated);

            foreach ($validated['items'] as $item) {
                $transfer->items()->attach($item['id'], [
                    'room_id' => $item['room_id'],
                    'quantity' => $item['quantity'],
                ]);
                $db_item = Item::find($item['id']);
                $db_item->room_id = $item['room_id'];
                $db_item->save();
            }
            return $transfer;
        });
        return new TransferResource($transfer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        return new TransferResource($transfer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetransferRequest $request, Transfer $transfer)
    {
        //TODO add update
        $transfer->update($request->validated());
        return new TransferResource($transfer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
    }
}
