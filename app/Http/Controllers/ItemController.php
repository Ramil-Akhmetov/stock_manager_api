<?php

namespace App\Http\Controllers;

use App\Events\ItemEvent;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Resources\Item\ItemCollection;
use App\Http\Resources\Item\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:items.create'], ['only' => ['store']]);
        $this->middleware(['permission:items.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:items.update'], ['only' => ['update']]);
        $this->middleware(['permission:items.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('search');
        $items = Item::filter($filters)->paginate();
        return new ItemCollection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        //todo debug this
        $validated = $request->validated();
        $item = DB::transaction(function () use ($validated) {
            $item = Item::create($validated);
            ItemEvent::dispatch($item);
            return $item;
        });
        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        //todo debug this
        $validated = $request->validated();
        $item = DB::transaction(function () use ($item, $validated) {
            $item->update($validated);
            ItemEvent::dispatch($item);
            return $item;
        });
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
