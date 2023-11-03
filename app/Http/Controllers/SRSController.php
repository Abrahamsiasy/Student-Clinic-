<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Alert;
use PDOException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class SRSController extends Controller
{


    public function srsData(Request $request)
    {
        if ($request->input('syncdata')) {
            $this->insert();
            session()->flash('success', 'SRS Data Successfully Synchronized');
        }

        if ($request->input('syncSetting')) {
            $this->setting();
            session()->flash('success', 'SRS Setting Successfully Synchronized');
        }

        if ($request->input('syncphoto')) {
            shell_exec(config('photo_sync_script'));
            session()->flash('success', 'SRS Data Successfully Synchronized');
        }
        if ($request->input('syncStudent')) {
            $this->unit();
            session()->flash('success', 'SRS Data Successfully Synchronized' . $this->student());
        }


        $campuses = DB::table('campuses')->count();
        $programs  = DB::table('programs')->count();
        $programLevels = DB::table('program_levels')->count();
        $programTypes = DB::table('program_types')->count();
        $enrollmentTypes = DB::table('enrollment_types')->count();
        $colleges = DB::table('colleges')->count();
        $departments = DB::table('departments')->count();

        return view('srs_data.dashboard', compact('data'));
    }


    public function unit()
    {
    }
    public function insert()
    {

    try {
        $dbcon = DB::connection('mysql_srs');
    } catch (\Throwable $th) {
        dd($th->getMessage());
    }

        $results = $dbcon->select(DB::raw(" SELECT s.id, sf.username, ifo.program_id, sf.first_name, sf.fathers_name, sf.grand_fathers_name, s.student_id, s.sex,
        IFNULL(sd.photo, '') AS photo, ifo.academic_year, ifo.year, 1,
        IF(ifo.is_registered = 1, 1, 0) AS is_registered, s.admission_year, 'Ethiopian' AS nationality, ifo.section, ifo.semester, s.birth_date,
        sd.entrance_exam_id, sd.mother_name AS adopter_name,
        sd.zone_id AS school_zone, sd.woreda AS school_woreda, sd.kebele AS school_kebele,
        sd.telephone AS phone, sd.family_phone
        FROM student s
        INNER JOIN sf_guard_user sf ON sf.id = s.sf_guard_user_id
        INNER JOIN student_info ifo ON s.id = ifo.student_id
        JOIN student_detail sd ON s.id = sd.student_id
        WHERE ifo.record_status = 1 AND s.id != 0 AND ifo.year != 0
        ORDER BY ifo.id DESC LIMIT  10000; 
    "));

     $data = $results;
        $targetTable = 'students'; 
        foreach ($data as $value) {
            // Convert the result object to an associative array
            $value = (array) $value;
            try {
                $moh = DB::connection('mysql');
                $result = $moh->table($targetTable)->updateOrInsert(
                    ['id_number' => $value['id']],
                    [
                        //'username' => $value['username'],
                        'first_name' => $value['first_name'],
                        'middle_name' => $value['fathers_name'],
                        'last_name' => $value['grand_fathers_name'],
                        'sex' => $value['sex'],
                        'program_id' =>$value['program_id'],
                        'photo' => $value['photo'],
                        'academic_year' => $value['academic_year'],
                        'year' => $value['year'],
                        //'campus_id'=>$value['campus_id'],
                        'year_of_entrance'=>$value['admission_year'],
                        'is_student_active' => 1,
                        'mobile_number'=>$value['phone'],
                        'is_registered' => $value['is_registered'],
                        'nationality' => $value['nationality'],
                        'section' => $value['section'],
                        'semester' => $value['semester'],
                        'date_of_birth' => $value['birth_date'],
                        'entrance_reg_no' => $value['entrance_exam_id'],
                    ]
                );


            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Data Successfully Synchronized');
        }
    }
    //////////////////////////////////////////////////////////////////////////////

    
    public function setting()
    {

        try {
            $dbcon = DB::connection('mysql_srs');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        $fields = ['id', 'name'];
        $query = "SELECT " . implode(', ', $fields) . " FROM department";
        $data =  $dbcon->select($query);
        $targetTable = 'departments'; 
        foreach ($data as $value) {
            $value = (array) $value; //// Convert the result object to an associative array
            try {
                    $sis = DB::connection('mysql');
                    $result = $sis->table($targetTable)->updateOrInsert(

                    ['department_id' => $value['id']],
                    [
                        'name' => $value['name']]

                );
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Department Successfully Synchronized');
        }

    ////////////////////////////////////////////////////////////////////////////////////////////
        $query = "SELECT " . implode(', ', $fields) . " FROM program";
        $data =  $dbcon->select($query);
        $targetTable = 'programs'; 
        foreach ($data as $value) {
            $value = (array) $value; //// Convert the result object to an associative array
            try {
                    $sis = DB::connection('mysql');
                    $result = $sis->table($targetTable)->updateOrInsert(

                    ['program_id' => $value['id']],
                    [
                        'name' => $value['name']]

                );
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Program Successfully Synchronized');
        }
///////////////////////////////////////////////////////////////////////////////////////

        $fields = ['id', 'name'];
        $query = "SELECT " . implode(', ', $fields) . " FROM programType";
        $data =  $dbcon->select($query);
        $targetTable = 'program_types'; 
        foreach ($data as $value) {
            $value = (array) $value; //// Convert the result object to an associative array
            try {
                    $sis = DB::connection('mysql');
                    $result = $sis->table($targetTable)->updateOrInsert(

                    ['program_Type_id' => $value['id']],
                    ['name' => $value['name']]

                );
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Program type Successfully Synchronized');
        }
///////////////////////////////////////////////////////////////////////////////
        $query = "SELECT " . implode(', ', $fields) . " FROM programLevel";
        $data =  $dbcon->select($query);
        $targetTable = 'program_levels'; 
        foreach ($data as $value) {
            $value = (array) $value; //// Convert the result object to an associative array
            try {
                    $sis = DB::connection('mysql');
                    $result = $sis->table($targetTable)->updateOrInsert(

                    ['program_level_id' => $value['id']],
                    [
                        'name' => $value['name']]

                );
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Program Level Successfully Synchronized');
        }
///////////////////////////////////////////////////////////////////////////////////
        $query = "SELECT " . implode(', ', $fields) . " FROM enrollment_type ";
        $data =  $dbcon->select($query);
        $targetTable = 'enrollment_types'; 
        foreach ($data as $value) {
            $value = (array) $value; //// Convert the result object to an associative array
            try {
                    $sis = DB::connection('mysql');
                    $result = $sis->table($targetTable)->updateOrInsert(
                    ['enrollment_type_id' => $value['id']],
                    [
                        'name' => $value['name']]
                );
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Enrollment type Successfully Synchronized');
        }
    }
    
}
