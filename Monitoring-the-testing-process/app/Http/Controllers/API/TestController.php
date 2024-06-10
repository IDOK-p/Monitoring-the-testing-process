<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Resources\TestResource;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::all();
        return response()->json(TestResource::collection($tests));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $test = Test::create($request->all());
        return response()->json(new TestResource($test), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = Test::findOrFail($id);
        return response()->json(new TestResource($test));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $test = Test::findOrFail($id);
        $test->update($request->all());
        return response()->json(new TestResource($test));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();
        return response()->json(null, 204);
    }
}
