<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Student;
use App\Models\GateScanner;
use Illuminate\Http\Request;
use App\Models\CurrentCardRead;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

class GateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $gateScanner = GateScanner::orderBy('gate_name','ASC')->get();
        $campuses = Campus::all();
        return view('app.gate.index',compact('gateScanner','campuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'gate_name' =>'required|string',
            'scanner_id' =>'required|string',
            'campus_id' =>'required|numeric',
            'location' =>'string',
        ]);
        
        GateScanner::create($validated);

        // return redirect()
        //     ->route('appointments.edit', $appointment)
        //     ->withSuccess(__('crud.common.created'));
        
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
        $gate = GateScanner::find($id);
        return view('app.gate.show', array('gate_id' => $id,'gate' => $gate));
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

    public function searchStudent(Request $request)
    {
        $check = 0;
        $id_number = $request->get('id_number');
        $student = Student::where('id_number',$id_number)->orWhere('rfid',$id_number)->first();
        if($student){
            $campus = Campus::find($student->campus_id);
            $program = Program::where('program_id', $student->program_id)->first();
            if($campus){
                return response()->json(['data' => $student, 'check'=>$check, 'campus' => $campus,'program' => $program]);
            }else{
                return response()->json(['data' => $student, 'check'=>$check, 'campus' => '' ,'program' => $program]);
            }
        }
    }

    public function checkCurrentData(Request $request){
        $gateScanner = GateScanner::find($request->gate_id);
        $data = CurrentCardRead::where('cjihao', $gateScanner->scanner_id)->first();
        $data = $data->card_id;
        CurrentCardRead::where('card_id',$data)->delete();
        return response()->json(['data' => $data]);
    }
}
