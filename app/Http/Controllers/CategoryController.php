<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:categories.create'],['only' => ['store']]);
        $this->middleware(['permission:categories.read'],['only' => ['index', 'show']]);
        $this->middleware(['permission:categories.update'],['only' => ['update']]);
        $this->middleware(['permission:categories.delete'],['only' => ['destroy']]);
    }
    public function index()
    {
        $categories = Category::latest()->paginate();
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
