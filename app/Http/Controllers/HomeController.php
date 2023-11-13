<?php

namespace App\Http\Controllers;

use App\Models\ClinicUser;
use App\Models\Encounter;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

require_once app_path('Helper/constants.php');
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();
        if ($user) {
            $encounters = Encounter::whereDate('created_at', now()->toDateString())
                ->where('registered_by', $user->id)
                ->paginate(15);
        } else {
            $encounters = Encounter::whereDate('created_at', now()->toDateString())->paginate(15);
        }
        return view('home', compact('encounters'));
    }
    public function checkIn(Request $request)
    {

        // $before = new DateTime('now', new DateTimeZone('Africa/Addis_Ababa'));
        // $after = new DateTime('now', new DateTimeZone('Africa/Addis_Ababa'));

        $now = Carbon::now();

        $studentId = trim($request->input('student_id'));
        $student = Student::where('id_number', $studentId)
            ->orWhere('rfid', $studentId)
            ->first();

        if ($student) {
            $alreadyCheckedInToday = Encounter::where('student_id', $student->id)->whereDate('created_at', $now->toDateString())->count();
            if ($alreadyCheckedInToday > 0) {
                return redirect()->route('home')->with('error', 'Already checked in today!');
            } 
                  $openedCase = Encounter::where('student_id', $student->id)->where('status', 2)->count();
           if ($openedCase >0){
               return redirect()->route('home')->with('error', 'There is existing opened case associated with given ID');
            }
            
            else {
                Encounter::create([
                    'student_id' => $student->id,
                    'status' => 1,
                    'closed_at' => null,
                    'clinic_id' => 1,
                    'check_in_time' => now(),
                    'doctor_id' => null,
                    'priority' => 1,
                    'registered_by' => Auth::user()->id,
                ]);

                // return redirect()->route('home')->with('success', 'Check-in successful!');
                return response()->json(['success' => true, 'message' => 'Check-in successful!']);
                //   return response()->json(['record_exists' => $student]);
            }
        } else {

            return redirect()->route('home')->with('error', 'No student record found!');
        }
    }

    public function mapRfid(Request $request)
    {

        $rfidToAdd = $request->input('rfid');
        $studentId = trim($request->input('student_id'));

        // dd($studentId );
        $student = Student::where('id', $studentId)->first();

        if ($student) {
            $student->update([
                'rfid' => $rfidToAdd,
            ]);
            return redirect()->route('home')->with('success', 'RFID successfully mapped to the student.');
        }

        return redirect()->route('home')->with('error', 'Student not found or RFID mapping failed.');
    }

    public function unmapRfid(Request $request)
    {
        $rfidToRemove = $request->input('rfid');
        $student = Student::where('rfid', $rfidToRemove)->first();
        if ($student) {
            $student->update([
                'rfid' => null,
            ]);


            return redirect()->route('home')->with('success', 'RFID successfully unmapped from the student.');
        }
        return redirect()->route('home')->with('error', 'Student not found or RFID unmapping failed.');
    }

    public function getEncouter(){


        $users = ClinicUser::all();
       
        $encounterLists = Encounter::orderBy('id', 'desc')->paginate(15);
         
            return view('app.encounters.encounter-list', compact('encounterLists','users'));
        

    }

    public function autoSearch(Request $request)
    {
        try {
           

           $query = trim($request->input('query'));
            if (empty($query)) {
                $encounterLists = Encounter::all();

               // return redirect()->route('encouter-list');
            }
             else {
             $student = Student::where('rfid', 'LIKE', "%$query%")->first();

            if (!$student) {
                return response()->json(['error' => 'Student not found.'], 404);
            }

            $encounterLists = Encounter::where('id', $query)->get();
        }
        
      return response()->json($encounterLists);
        } 
    catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    
    }
    public function dashboard()
    {

        $students = Student::count();

        $encounters = Encounter::count();
        $users = DB::table('users')->count();
        $clinics = DB::table('clinic')->count();
        $programs = DB::table('programs')->count();
        $clinic_users = DB::table('clinic_users')->count();
        // $count = DB::table('students')->count();
        // $count = Student::where('status','=','1')->count();

        return view('dashboard', compact(
            'users',
            'students',
            'clinics',
            'programs',
            'clinic_users',
            'encounters',

        ));
    }
}
