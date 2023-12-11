<?php

namespace App\Exports;

use App\Helper\MainDiagnosesHelper;
use Carbon\Carbon;
use App\Models\MainDiagnosis;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

class OPDReportExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $diagnoses;

     public function __construct($startDate, $endDate)
    {
        $mainDiagnoses = MainDiagnosis::with('student')->with('diagnosis')->whereBetween('created_at', [$startDate,$endDate])->get();
        $mainDiagnosesHelper = new MainDiagnosesHelper();     
        $this->diagnoses = $mainDiagnosesHelper->diagnosis($mainDiagnoses);
        
    }


    public function view(): View
    {
        // return view('app.report.table',['diagnoses' => $this->diagnoses]);
        return view('table',['diagnoses' => $this->diagnoses]);
    }
    
}
