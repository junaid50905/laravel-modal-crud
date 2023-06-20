<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_roll' => 'required|unique:students,student_roll|integer',
            'student_name' => 'required',
            'student_batch' => 'required',
        ]);
        Student::create([
            'student_roll' => $request->student_roll,
            'student_name' => $request->student_name,
            'student_batch' => $request->student_batch,
        ]);
        return redirect()->route('student.index')->with('success', 'Student successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student_info = Student::find($id);
        // return response()->json([
        //     'status' => 200,
        //     'student_info' => $student_info,
        // ]);

        return response()->json($student_info);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'student_roll' => 'required|integer',
            'student_name' => 'required',
            'student_batch' => 'required',
        ]);
        Student::where('id', $request->id)->update([
                    'student_roll' => $request->student_roll,
                    'student_name' => $request->student_name,
                    'student_batch' => $request->student_batch,
                ]);
        return redirect()->route('student.index')->with('success', 'Student information updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return redirect()->route('student.index')->with('success', 'Student successfully removed');
    }
}
