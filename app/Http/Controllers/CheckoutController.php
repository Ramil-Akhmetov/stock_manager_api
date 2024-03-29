<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\StoreCheckoutRequest;
use App\Http\Requests\Checkout\UpdateCheckoutRequest;
use App\Http\Resources\Checkout\CheckoutCollection;
use App\Http\Resources\Checkout\CheckoutResource;
use App\Models\Checkout;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:checkouts.create'], ['only' => ['store']]);
        $this->middleware(['permission:checkouts.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:checkouts.update'], ['only' => ['update']]);
        $this->middleware(['permission:checkouts.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $filters = $request->all('search');
        $checkouts = Checkout::paginate();
        return new CheckoutCollection($checkouts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckoutRequest $request)
    {
        $validated = $request->validated();
        $validated += [
            'user_id' => $request->user()->id,
        ];

        //todo maybe should use event
        $checkout = DB::transaction(function () use ($validated) {
            $checkout = Checkout::create($validated);

            foreach ($validated['item_ids'] as $item_id) {
                $item = Item::find($item_id);
                $checkout->items()->attach($item->id, [
                    'room_id' => $item->room_id,
                    'quantity' => $item->quantity,
                ]);
            }
            return $checkout;
        });
        return new CheckoutResource($checkout);
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkout $checkout)
    {
        return new CheckoutResource($checkout);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecheckoutRequest $request, Checkout $checkout)
    {
        //todo add update
        $checkout->update($request->validated());
        return new CheckoutResource($checkout);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        $checkout->delete();
    }
}
