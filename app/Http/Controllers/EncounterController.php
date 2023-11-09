<?php

namespace App\Http\Controllers;


use App\Models\Room;
use App\Models\User;
use App\Models\Clinic;
use App\Models\LabTest;
use App\Models\Student;
use App\Models\Encounter;
use Illuminate\View\View;
use App\Models\LabCatagory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EncounterStoreRequest;
use App\Http\Requests\EncounterUpdateRequest;
use App\Models\ClinicUser;

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
    public function index(Request $request): View
    {
        //dd(STATUS_IN_PROGRESS);
        $this->authorize('view-any', Encounter::class);

        $search = $request->get('search', '');
        $status = STATUS_CHECKED_IN; // list of students accepted by receptionist

        // Retrieve encounters with the desired status
        $desiredStatusEncounters = Encounter::search($search)
            ->where('status', $status)
            ->orderBy('created_at', 'asc') // Order by creation timestamp (first come, first served)
            ->paginate(10)
            ->withQueryString();
        // dd($desiredStatusEncounters);
        // Retrieve encounters with other statuses (excluding the desired status)
        $otherStatusEncounters = Encounter::search($search)
            ->where('status', '<>', $status)
            ->orderBy('created_at', 'asc') // Order by creation timestamp in descending order
            ->paginate(10)
            ->withQueryString();

        // Combine the results
        $encounters = $desiredStatusEncounters->concat($otherStatusEncounters);

        return view('app.encounters.index', compact('encounters', 'search'));
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

    public function show(Request $request, Encounter $encounter): View
    {


        // $doctors = User::whereHas('roles', function ($query) {
        //     $query->where('name', DOCTOR_ROLE);
        // })->get();
        // dd(User::where('id', '!=', 10));

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers->id)->get();



        //dd($doctors);
        $this->authorize('view', $encounter);
        $labTests =  LabTest::all();
        $labCategories =  LabCatagory::all();

        //get rooms that belongs to the given encounter clinic
        // dd(Clinic::find(1)->rooms->first()->name);
        //dd($encounter->Doctor);
        $clinc_id = $encounter->clinic->id;
        $rooms = Room::where('clinic_id', $encounter->clinic->id)->get();

        // dd($rooms);


        return view('app.encounters.show', compact('encounter',  'doctors', 'labCategories', 'rooms'));
    }

    // call the next encounter 
    public function callNext(Request $request, Encounter $encounter)
    {
        // $doctors = User::whereHas('roles', function ($query) {
        //     $query->where('name', DOCTOR_ROLE);
        // })->get();
        $doctorId = Auth()->user()->clinicUsers->id;

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers->id)->get();

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
            $encounter->doctor_id = Auth()->user()->clinicUsers->id;

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

            $doctors = User::where('id', '!=', Auth::user()->clinicUsers->id)->get();

            //dd($doctors);
            $this->authorize('view', $encounter);
            $labTests =  LabTest::all();
            $labCategories =  LabCatagory::all();

            //get rooms that belongs to the given encounter clinic
            $rooms = $encounter->clinic->rooms;
            // dd($rooms);
            $danger_message = 'No more encounters available.';



            return view('app.encounters.show', compact('encounter',  'doctors', 'labCategories', 'rooms', 'danger_message'));
        }
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
        //dd($encounter);

        //dd($encounter->Doctor->room->id);

        //get the clinic id and add it to the encounter 
        //dd($encounter->Doctor->rooms->first()->clinic->id);
        //dd($encounter->Doctor->room->clinic->id);
        $encounter->clinic_id = $encounter->Doctor->clinicUsers->room->clinic->id;


        //dd($encounter->Doctor->user->name);
        //dd($encounter);

        $encounter->save();

        $encounterUrl = route('encounters.show', ['encounter' => $encounter]);

        //return redirect($nextEncounterUrl)->with(compact('encounter'));
        return redirect($encounterUrl);
    }

    //close encounter
    public function closeEencounter(Request $request, Encounter $encounter)
    {
        // $doctors = User::whereHas('roles', function ($query) {
        //     $query->where('name', DOCTOR_ROLE);
        // })->get();

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers->id)->get();

        $this->authorize('view', $encounter);
        //dd($encounter->status);

        // Get the current encounter's status from the form input
        $currentStatus = $encounter;
        // Update the current encounter's status to 1
        $encounter->status = STATUS_COMPLETED;
        $encounter->closed_at = now();
        // dd(now());

        $encounter->save();

        // Find the next encounter with the same status and ID greater than the current encounter
        $nextEncounter = Encounter::where('status', STATUS_CHECKED_IN)
            ->where('id', '>', $encounter->id)
            ->first();


        // Redirect to the next encounter's show page with the updated ID in the URL
        //dd($nextEncounter);
        if ($nextEncounter) {
            $encounter = $nextEncounter;
            $nextEncounterId = $nextEncounter->id;
            $nextEncounterUrl = route('encounters.show', ['encounter' => $nextEncounterId]);

            //return redirect($nextEncounterUrl)->with(compact('encounter'));
            return redirect($nextEncounterUrl);
        } else {
            //dd($encounter);
            // Redirect to a different route or display an appropriate message
            // $doctors = User::whereHas('roles', function ($query) {
            //     $query->where('name', DOCTOR_ROLE);
            // })->get();


            $doctors = User::where('id', '!=', Auth::user()->clinicUsers->id)->get();




            //dd($doctors);
            $this->authorize('view', $encounter);
            $labTests =  LabTest::all();
            $labCategories =  LabCatagory::all();

            //get rooms that belongs to the given encounter clinic
            $rooms = $encounter->clinic->rooms;
            // dd($rooms);
            $danger_message = 'No more encounters available.';



            return view('app.encounters.show', compact('encounter',  'doctors', 'labCategories', 'rooms', 'danger_message'));
        }
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

        $doctors = User::where('id', '!=', Auth::user()->clinicUsers->id)->get();

        return view('encounters.changeDoctor', compact('encounter', 'doctors'));
    }


    public function room(Request $request, Encounter $encounter)
    {
        // Validate the request data
        $request->validate([
            'encounter_id' => 'required|exists:encounters,id',
            // 'room_id' => 'required|exists:rooms,id',
        ]);
        $doctor = $encounter->doctor;
        $doctor->room_id = $request->room_id;
        $doctor->save();
        // dd($doctor);
        //dd($encounter->doctor->user->name);
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
}
