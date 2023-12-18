<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class GateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        // dd($request);
        $this->authorize('view-any', Student::class);

        $search = $request->get('search', '');

        $students = Student::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();
        // dd($request);
        $student = Student::search($search)->first();
        // dd($student);


        return view('app.gate.index', compact('students', 'search', 'student'));
    }

    public function store(Request $request): View
    {
        // dd($request);
        $this->authorize('view-any', Student::class);

        $search = $request->get('search', '');

        $students = Student::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();
        // dd($request);
        $student = Student::search($search)->first();
        // dd($student);


        return view('app.gate.index', compact('students', 'search', 'student'));
    }

    public function searchStudent(Request $request)
    {
        $this->authorize('view-any', Student::class);

        dd($request);

        $studentId = trim($request->input('student_id'));
        $student = Student::where('id_number', $studentId)
            ->orWhere('rfid', $studentId)
            ->first();

        if ($student) {
            // return $studnet 
            return view('app.gate.index', compact('student'));
        } else {
            return redirect()->route('gate')->with('error', 'No student record found!');
        }
        return response()->json('data', $student);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        dd($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storee(Request $request)
    {
        //
        $this->authorize('view-any', Student::class);

        // dd($request);

        $studentId = trim($request->input('student_id'));
        $student = Student::where('id_number', $studentId)
            ->orWhere('rfid', $studentId)
            ->first();
        // dd($student);

        if ($student) {
            // return $studnet 
            return view('app.gate.index', compact('student'));
        } else {
            return redirect()->route('gate.index')->with('error', 'No student record found!');
        }
        return response()->json('data', $student);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
