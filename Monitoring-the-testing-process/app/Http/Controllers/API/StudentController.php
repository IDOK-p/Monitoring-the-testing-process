<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return response()->json(StudentResource::collection($students));
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
            'patronymic' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:students,email',
            'city_id' => 'required|integer',
            'school_id' => 'required|integer',
            'class_id' => 'integer|nullable',
        ]);

        $student = Student::create($request->all());
        return response()->json(new StudentResource($student), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json(new StudentResource($student));
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
            'patronymic' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:students,email,' . $id,
            'city_id' => 'required|integer',
            'school_id' => 'required|integer',
            'class_id' => 'integer|nullable',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json(new StudentResource($student));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(null, 204);
    }
}
