<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Models\Room;
use App\Models\User;
use App\Models\Clinic;
use App\Models\LabTest;
use App\Models\Student;
// use Barryvdh\DomPDF\PDF;
use App\Models\Diagnosis;
use App\Models\Encounter;
use Illuminate\View\View;
use App\Models\ClinicUser;
use App\Models\LabCatagory;
use Illuminate\Http\Request;
use App\Models\MainDiagnosis;
use App\Models\LabTestRequest;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EncounterStoreRequest;
use App\Http\Requests\EncounterUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

require_once app_path('Helper/constants.php');

class EncounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function reception(Request $request): View
    {
        $this->authorize('view-any', Encounter::class);

        $request->validate([
            'search' => 'nullable|string',
        ]);

        $search = $request->input('search', '');
        $searchError = '';
        $students = [];

        if (!empty($search)) {
            $students = Student::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif ($request->has('search') && strlen($search) < 2) {
            $searchError = 'Search term must be at least 2 characters.';
        }


        // $clinicUser = Auth::user()->clinicUsers?->clinics->first();
        $clinicUser = Auth::user()->clinicUsers->room?->clinic;
        // dd(Auth::user()->clinicUsers->room->clinic);

        return view('app.reception.index', compact('students', 'search', 'searchError', 'clinicUser'));
    }


    public function generateSickLeavePdf($encounterid)

    {


        $encounter = Encounter::findOrFail($encounterid);
        // $data = [
        //     'encounter' => $encounter,
        // ];


        $pdf = Pdf::loadView('app.encounters.sick_leave', ['encounter' =>  $encounter]);

        return $pdf->setPaper('a5')->download('sick_leave.pdf');
    }


    public function labWaiting(Request $request): View
    {
        $this->authorize('view-any', Encounter::class);

        $pendinglabs = Auth::user()->encounters->flatMap->labRequests->where('status', null)->where('result', null)->count();
        $labResults =  Auth::user()->encounters->flatMap->labRequests->whereNotNull('status')->whereNotNull('result')->count();
        $myPateints =   Auth::user()->encounters->count();
        $labRequests = LabTestRequest::whereNull('status')->whereNull('result')->get();
        $mylabs =   $pendinglabs + $labResults;




        $currentUserId = Auth::id();
        $encounters = Encounter::where('status', 2)
            ->whereNotNull('doctor_id')
            ->where('doctor_id', $currentUserId)
            //->whereDate('created_at',today())
            ->whereDate('created_at', '>=', now()->subDays(2))
            ->oldest('id') // Order by 'id' in ascending order
            ->paginate(10)
            ->withQueryString();
        $clinicUser = Auth::user()?->clinicUsers?->room?->clinic;


        return view('app.encounters.waiting-lab', compact('encounters', 'labResults', 'labRequests', 'pendinglabs', 'clinicUser', 'mylabs', 'myPateints'));
    }



    public function index(Request $request): View
    {
        //dd(STATUS_IN_PROGRESS);
        $this->authorize('view-any', Encounter::class);
        $clinic_id = Auth::user()->clinicUsers?->clinic_id;
        // dd($clinic_id);

        $search = $request->get('search', '');
        $status = STATUS_CHECKED_IN; // list of students accepted by receptionist


        // Retrieve encounters with the desired status
        $desiredStatusEncountersQuery = Encounter::search($search)
            ->where('status', $status);

        if ($clinic_id) {
            $desiredStatusEncountersQuery->where('clinic_id', $clinic_id);
        }

        $desiredStatusEncounters = $desiredStatusEncountersQuery
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Retrieve encounters with other statuses (excluding the desired status)
        $otherStatusEncountersQuery = Encounter::search($search)
            ->where('status', '<>', $status);

        if ($clinic_id) {
            $otherStatusEncountersQuery->where('clinic_id', $clinic_id);
        }

        $otherStatusEncounters = $otherStatusEncountersQuery
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();


        // Combine the results
        $encounters = $desiredStatusEncounters->concat($otherStatusEncounters);
        // $reception_id = $encounters[0]?->registered_by;
        $rooms = Clinic::find($clinic_id)?->rooms;
        // dd($rooms);


        // dd($encounters);

        return view('app.encounters.index', compact('encounters', 'search', 'rooms'));
    }

    public function updateEncounterStatus()
    {

        Encounter::where('created_at', '<=', now()->subHour())
            ->where('status', STATUS_IN_PROGRESS)
            ->whereNull('arrived_at')
            ->update(['status' => STATUS_MISSED]);

        return response()->json(['message' => 'Encounter statuses updated successfully']);
    }

    public function openedEencounter(Request $request): View
    {

        $this->authorize('view-any', Encounter::class);
        $clinic_id = Auth::user()->clinicUsers?->clinic_id;
        $search = $request->get('search', '');

        $desiredStatusEncountersQuery = Encounter::search($search)
            ->where('status', STATUS_IN_PROGRESS)
            ->whereNull('arrived_at')
            ->whereNotNull('doctor_id');

        if ($clinic_id) {
            $desiredStatusEncountersQuery->where('clinic_id', $clinic_id);
        }

        $encounters = $desiredStatusEncountersQuery
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        $rooms = Clinic::find($clinic_id)?->rooms;

        return view('app.encounters.opened', compact('encounters', 'search', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Encounter::class);

        $clinics = Clinic::pluck('name', 'id');

        $student = Student::pluck('first_name', 'id');

        return view('app.encounters.create', compact('clinics', 'student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EncounterStoreRequest $request): RedirectResponse
    {
        // dd($request->student_id);
        $this->authorize('create', Encounter::class);
        $validated = $request->validated();
        // dd($validated); //registered_by
        $encounter = new Encounter($validated);
        $encounter->save();
        // return redirect()
        //     ->route('encounters.edit', $encounter)
        //     ->withSuccess(__('crud.common.created'));
        return redirect()
            ->back()
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */

    public function search(Request $request)
    {


        try {
            $id_number = $request->input('student_id');
            $student = Student::where('id_number', $id_number)->firstOrFail();
            $encounters = $student->encounter;
            $encounter =   $student->encounter[0];

            $clinc_id = $encounter->clinic?->id;
            $rooms = Room::where('clinic_id', $encounter->clinic?->id)->get();
            $doctors = User::where('id', '!=', Auth::user()->clinicUsers?->id)->get();
            $labTests =  LabTest::all();
            $labCategories =  LabCatagory::all();
            $allDignosis = Diagnosis::all();



            return view('app.encounters.show', compact('encounter', 'encounters', 'student', 'allDignosis', 'rooms', 'doctors', 'labCategories'));
        } catch (ModelNotFoundException $exception) {

            return redirect()->back()->with('error', 'No student record found with the given ID.');
        }
    }


    public function show(Request $request, Encounter $encounter): View
    {

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers?->id)->get();

        $student = Student::findOrFail($encounter->student->id);


        // dd($student );
        $encounters = $student->encounter;

        $maindiagnosises = $encounter->mainDiagnoses;
        $vitalSigns = $encounter->vitalSigns;
        $labTestRequests = $encounter->labTestRequests;

        $this->authorize('view', $encounter);
        $labTests =  LabTest::all();
        $labCategories =  LabCatagory::all();
        $clinc_id = $encounter->clinic?->id;
        $rooms = Room::where('clinic_id', $encounter->clinic?->id)->get();

        //return view('students.encounters', ['student' => $student, 'encounters' => $encounters]);
        $allDignosis = Diagnosis::all();
        // dd($maindiagnosises);


        return view('app.encounters.show', compact('encounter', 'encounters', 'student', 'labTestRequests', 'allDignosis', 'maindiagnosises', 'vitalSigns', 'doctors', 'labCategories', 'rooms'));
    }

    // call the next encounter 
    public function callNext(Request $request, Encounter $encounter)
    {
        // $doctors = User::whereHas('roles', function ($query) {
        //     $query->where('name', DOCTOR_ROLE);
        // })->get();

        $doctorId = Auth()->user()->id;

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers?->id)->get();

        $this->authorize('view', $encounter);
        //dd($encounter->status);

        // Get the current encounter's status from the form input
        $currentStatus = $encounter;
        // Update the current encounter's status to 1
        $encounter->status = STATUS_WAITING;
        $encounter->save();

        // Find the next encounter with the same status and ID greater than the current encounter
        $nextEncounter = Encounter::where('status', STATUS_CHECKED_IN)
            ->where('id', '>', $encounter->id)
            ->first();



        // Redirect to the next encounter's show page with the updated ID in the URL
        //dd($nextEncounter);
        if ($nextEncounter) {
            $encounter = $nextEncounter;
            // dd($nextEncounter);
            $encounter->doctor_id = Auth()->user()->id;

            $encounter->status = STATUS_IN_PROGRESS;
            $encounter->save();
            //$patient = Patient::findOrFail($encounter->patient_id);
            $nextEncounterId = $nextEncounter->id;
            $nextEncounterUrl = route('encounters.show', ['encounter' => $nextEncounterId]);

            //return redirect($nextEncounterUrl)->with(compact('encounter'));
            return redirect($nextEncounterUrl);
        } else {
            // Redirect to a different route or display an appropriate message
            // $doctors = User::whereHas('roles', function ($query) {
            //     $query->where('name', DOCTOR_ROLE);
            // })->get();

            $doctors = User::where('id', '!=', Auth::user()->clinicUsers?->id)->get();

            //dd($doctors);
            $this->authorize('view', $encounter);
            $labTests =  LabTest::all();
            $labCategories =  LabCatagory::all();

            //get rooms that belongs to the given encounter clinic
            $rooms = $encounter?->clinic?->rooms;
            // dd($rooms);
            $danger_message = 'No more encounters available.';

            $allDignosis = Diagnosis::all();




            return view('app.encounters.show', compact('encounter',  'doctors', 'allDignosis', 'labCategories', 'rooms', 'danger_message'));
        }
    }








    public function toggleArrival(Request $request)
    {

        $encounterId = trim($request->input('encounter_id'));
        $encounter = Encounter::where('id',   $encounterId)->first();

        if ($encounter) {

            if ($encounter->arrived_at == null) {
                $encounter->update(['arrived_at' => now(), 'status' => STATUS_IN_PROGRESS]);
            } else {
                $encounter->update([
                    'arrived_at' => null, 'status' => STATUS_MISSED, 'doctor_id' => null,
                    'closed_at' => null
                ]);
            }
            return redirect()->back()->with('success', 'Patient Arrival Status changed.');
        }

        return redirect()->back()->with('error', 'Error happen while changing status.');
    }


    public function approve(Request $request)
    {

        $labTestRequest_id = trim($request->input('labTestRequest_id'));
        $labTestRequest = LabTestRequest::where('id',   $labTestRequest_id)->first();

        $encounter = $labTestRequest->encounter;
        if ($labTestRequest) {

            if ($labTestRequest->closed_at == null) {
                $labTestRequest->update(['closed_at' => now()]);
            }

            return redirect()->back()->with('success', 'Lab result approved');

            // return redirect()->route('app.encounters.show', ['encounter' =>$encounter])->with('success', 'Lab result approved');


        }

        return redirect()->back()->with('error', 'Error happen while approving lab');
    }



    public function rechecin(Request $request)
    {

        $encounterId = trim($request->input('encounter_id'));
        $encounter = Encounter::where('id',   $encounterId)->first();

        if ($encounter) {

            $encounter->update([
                'status' => STATUS_CHECKED_IN,
                'arrived_at' => null,
                'doctor_id' => null,
                'closed_at' => null
            ]);



            return redirect()->back()->with('success', 'Status changed successfully.');
        }

        return redirect()->back()->with('error', 'Error happen while changing status.');
    }



    public function  changeStatus(Request $request)
    {

        $encounterId = trim($request->input('encounter_id'));
        $encounter = Encounter::where('id',   $encounterId)->first();

        if ($encounter) {
            if ($encounter->status == STATUS_IN_PROGRESS) {
                $encounter->update([
                    'status' => STATUS_MISSED,
                    'arrived_at' => null
                ]);
            } else {

                $encounter->update([
                    'status' => STATUS_IN_PROGRESS,
                    'arrived_at' => now()
                ]);
            }

            return redirect()->route('encounters.index')->with('success', 'Status changed successfully.');
        }

        return redirect()->back()->with('error', 'Error happen while changing status.');
    }




    //doctor accept encounter 
    public function accept(Encounter $encounter)
    {
        // Get the authenticated user's ID
        $doctorId = Auth()->user()->id;
        //dd($doctorId);

        // Update the encounter's status and doctor_id
        $encounter->status = STATUS_IN_PROGRESS;

        $encounter->doctor_id = $doctorId;
        $encounter->accepted_at = now();
        //dd($encounter);

        //dd($encounter->Doctor->room->id);

        //get the clinic id and add it to the encounter 
        //dd($encounter->Doctor->rooms->first()->clinic->id);
        //dd($encounter->Doctor->room->clinic->id);
        $encounter->clinic_id = $encounter?->Doctor?->clinicUsers?->room?->clinic?->id;


        //dd($encounter->Doctor->user->name);
        //dd($encounter);

        $encounter->save();

        $encounterUrl = route('encounters.show', ['encounter' => $encounter]);

        //return redirect($nextEncounterUrl)->with(compact('encounter'));
        return redirect($encounterUrl);
    }

    //close encounter and call next
    public function closeEencounter(Request $request, Encounter $encounter)
    {

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers?->id)->get();
        $this->authorize('view', $encounter);



        if ($encounter) {
            $encounter->update(['status' => STATUS_COMPLETED, 'closed_at' => now(), 'arrived_at' => now()]);
        }

        return redirect()->route('encounters.index')->with('success', 'CLosed Encounter successfully');
    }



    //close encounter and call next
    public function termniateEencounter(Encounter $encounter)
    {

        $this->authorize('view', $encounter);

        // Get the current encounter's status from the form input
        // Update the current encounter's status to 1
        $encounter->status = STATUS_COMPLETED;
        $encounter->closed_at = now();
        // dd($encounter);
        $encounter->save();
        return redirect()->route('encounters.index')->with('success', 'Encounter Terminated successfully');
    }


    public function changeDoctor(Request $request, Encounter $encounter)
    {
        if ($request->isMethod('post')) {
            $newDoctorId = $request->input('newDoctorId');
            //dd($newDoctorId);
            $encounter->doctor_id = $newDoctorId;
            $encounter->save();

            // Redirect or return a response as needed
            return redirect()->route('encounters.index')->with('success', 'Doctor assigned successfully');
        }

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers?->id)->get();

        return view('encounters.changeDoctor', compact('encounter', 'doctors'));
    }


    public function roomChange(Request $request, Encounter $encounter)
    {
        // Validate the request data
        $request->validate([
            'encounter_id' => 'required|exists:encounters,id',
            // 'room_id' => 'required|exists:rooms,id',
        ]);
        $room_id = $request->room_id;
        //dd($encounter);
        $doctor = $encounter->Doctor->clinicUsers;
        // dd($doctor);
        $doctor->room_id = $request->room_id;
        $doctor->save();
        //dd($encounter->doctor->user->name);
        return redirect()->back()->with('success', 'Room updated successfully.');
    }



    public function roomChangeAll(Request $request)
    {
        //dd("here");
        // Validate the request data
        $request->validate([
            'room_id' => 'required|exists:room,id',
            // 'room_id' => 'required|exists:rooms,id',
        ]);
        $room_id = $request->room_id;
        //dd($encounter);
        $doctor = Auth::user()->clinicUsers;
        $doctor->room_id = $request->room_id;
        // dd($doctor);

        $doctor->save();
        return redirect()->back()->with('success', 'Room updated successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Encounter $encounter): View
    {
        $this->authorize('update', $encounter);

        $clinics = Clinic::pluck('name', 'id');

        return view('app.encounters.edit', compact('encounter', 'clinics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EncounterUpdateRequest $request,
        Encounter $encounter
    ): RedirectResponse {
        $this->authorize('update', $encounter);

        $validated = $request->validated();

        $encounter->update($validated);

        return redirect()
            ->route('encounters.edit', $encounter)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Encounter $encounter
    ) {
        $this->authorize('delete', $encounter);

        $encounter->delete();

        // return redirect()
        //     ->route('encounters.index')
        //     ->withSuccess(__('crud.common.removed'));
    }



    public function createMainDignosis(Request $request)
    {

        // $mainDiagnosis = MainDiagnosis::create($request);
        // Retrieve values from the form
        $studentId = $request->input('student_id');
        $encounterId = $request->input('encounter_id');
        $clinicUserId = $request->input('clinic_user_id');
        $diagnosisId = $request->input('diagnosis_id')[0];

        mainDiagnosis::create([
            'clinic_user_id' => $clinicUserId,
            'student_id' => $studentId,
            'encounter_id' => $encounterId,
            'diagnosis_id' => $diagnosisId,
            // Add other fields as needed
        ]);
        return redirect()->back()->with('success', 'Main Dignosis created successfully.');
    }
}
