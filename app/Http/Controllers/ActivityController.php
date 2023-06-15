<?php

namespace App\Http\Controllers;

use App\Http\Resources\Activity\ActivityCollection;
use App\Http\Resources\Activity\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);

        $this->middleware(['permission:activities.read'], ['only' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all('search');
        $activities = Activity::filter($filters)->latest()->get();
        return new ActivityCollection($activities);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return new ActivityResource($activity);
    }
}
