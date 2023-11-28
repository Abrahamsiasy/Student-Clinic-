<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\MainDiagnosis;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PrescriptionStoreRequest;
use App\Http\Requests\PrescriptionUpdateRequest;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

require_once app_path('Helper/constants.php');
class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // $this->authorize('view-any', Prescription::class);

        if (Auth::user()->can('pharmacy.prescriptions.*')) {

            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $search = $request->get('search', '');
            $prescriptions = Prescription::where('clinic_id', $pharmacy->clinic_id)->where('status', 0)->search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();


            return view('app.prescriptions.studentPrescriptionList', compact('prescriptions', 'search'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');




        // $prescriptions = Prescription::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        // return view(
        //     'app.prescriptions.index',
        //     compact('prescriptions', 'search')
        // );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Prescription::class);

        $mainDiagnoses = MainDiagnosis::pluck('id', 'id');

        return view('app.prescriptions.create', compact('mainDiagnoses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Prescription::class);

        $validated = $request->validated();

        $prescription = Prescription::create($validated);

        return redirect()
            ->route('prescriptions.edit', $prescription)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Prescription $prescription): View
    {
        // $this->authorize('view', $prescription);
        if (Auth::user()->can('pharmacy.prescriptions.*')) {
            return view('app.prescriptions.show', compact('prescription'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Prescription $prescription): View
    {
        $this->authorize('update', $prescription);

        $mainDiagnoses = MainDiagnosis::pluck('id', 'id');

        return view(
            'app.prescriptions.edit',
            compact('prescription', 'mainDiagnoses')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PrescriptionUpdateRequest $request,
        Prescription $prescription
    ): RedirectResponse {
        $this->authorize('update', $prescription);

        $validated = $request->validated();

        $prescription->update($validated);

        return redirect()
            ->route('prescriptions.edit', $prescription)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Prescription $prescription
    ): RedirectResponse {
        $this->authorize('delete', $prescription);

        $prescription->delete();

        return redirect()
            ->route('prescriptions.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function approve(Prescription $prescription)
    {
        // dd($prescription->itemInPharmacy);
        // dd($prescription->itemInPharmacy->amount);
        // $prescription->itemInPharmacy->amount -= 1;

        if (Auth::user()->can('pharmacy.prescriptions.approve')) {
        $prescription->status = 1;
        $prescription->save();

        return redirect()
            ->route('prescriptions.index')
            ->withSuccess(__('Approved succefully'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }


    public function reject(Prescription $prescription)
    {

        if (Auth::user()->can('pharmacy.prescriptions.reject')) {
        $prescription->status = -1;

        $prescription->save();
        return redirect()
            ->route('prescriptions.index')
            ->withSuccess(__('Rejected succefully'));
    }
    abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
}

    public function history(Request $request): View
    {

        if (Auth::user()->can('pharmacy.prescriptions.*')) {

            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $search = $request->get('search', '');
            $prescriptions = Prescription::where('clinic_id', $pharmacy->clinic_id)->where('status', 1)->search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
            $rejectedPrescriptions = Prescription::where('clinic_id', $pharmacy->clinic_id)->where('status', -1)->search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();


            return view('app.prescriptions.history', compact('prescriptions', 'rejectedPrescriptions', 'search'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }
}
