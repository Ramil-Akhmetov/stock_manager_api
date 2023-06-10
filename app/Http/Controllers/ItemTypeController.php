<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemType\StoreItemTypeRequest;
use App\Http\Requests\ItemType\UpdateItemTypeRequest;
use App\Http\Resources\ItemType\ItemTypeCollection;
use App\Http\Resources\ItemType\ItemTypeResource;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:item_types.create'], ['only' => ['store']]);
        $this->middleware(['permission:item_types.read'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:item_types.update'], ['only' => ['update']]);
        $this->middleware(['permission:item_types.delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('search');
        $item_types = ItemType::filter($filters)->paginate();
        return new ItemTypeCollection($item_types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemTypeRequest $request)
    {
        $item_type = ItemType::create($request->validated());
        return new ItemTypeResource($item_type);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemType $item_type)
    {
        return new ItemTypeResource($item_type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemTypeRequest $request, ItemType $item_type)
    {
        $item_type->update($request->validated());
        return new ItemTypeResource($item_type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $item_type)
    {
        $item_type->delete();
    }
}
