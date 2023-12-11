<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Andegna\DateTimeFactory;
use Illuminate\Http\Request;
use App\Models\MainDiagnosis;
use App\Exports\OPDReportExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Helper\MainDiagnosesHelper;



class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MainDiagnosesHelper $mainDiagnosesHelper)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $ethStart = new \Andegna\DateTime($startDate);
        $ethEnd = new \Andegna\DateTime($endDate);
        $reportDate = $ethStart->getDay() ."/". $ethStart->getMonth() ."/". $ethStart->getYear() ." - ". $ethEnd->getDay() ."/". $ethEnd->getMonth() ."/". $ethEnd->getYear();

        $mainDiagnoses = MainDiagnosis::with('student')->with('diagnosis')->whereBetween('created_at', [$startDate,$endDate])->get();
        $diagnoses = $mainDiagnosesHelper->diagnosis($mainDiagnoses);
        
        return view('app.report.index', compact('diagnoses','startDate','endDate','reportDate'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request, MainDiagnosesHelper $mainDiagnosesHelper)
    {
        //
        $sd = explode('/',$request->sdate);
        $ed = explode('/',$request->edate);
        $start = DateTimeFactory::of($sd[2], $sd[1], $sd[0]);
        $end = DateTimeFactory::of($ed[2], $ed[1], $ed[0]);
        
        if($start->toGregorian()> $end->toGregorian()){
            return redirect()->back();
        }
        $startDate = $start->toGregorian()->format('Y-m-d');
        $endDate = $end->toGregorian()->format('Y-m-d');
        $mainDiagnoses = MainDiagnosis::with('student')->with('diagnosis')->whereBetween('created_at', [$start->toGregorian(),$end->toGregorian()])->get();
        
        $ethStart = new \Andegna\DateTime($start->toGregorian());
        $ethEnd = new \Andegna\DateTime($end->toGregorian());
        $reportDate = $ethStart->getDay() ."/". $ethStart->getMonth() ."/". $ethStart->getYear() ." - ". $ethEnd->getDay() ."/". $ethEnd->getMonth() ."/". $ethEnd->getYear();

        $diagnoses = $mainDiagnosesHelper->diagnosis($mainDiagnoses);
       
        return view('app.report.index', compact('diagnoses','startDate','endDate','reportDate'));
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


    public function exportExcel($startDate,$endDate)
    {
        return (new OPDReportExport($startDate,$endDate))->download('opd_report.xlsx');
    }

    public function convertToEth(){

    }
}
