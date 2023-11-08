<?php

namespace App\Http\Controllers;


use App\Models\Campus;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Requests\PharmacyStoreRequest;
use App\Http\Requests\PharmacyUpdateRequest;
use App\Models\Clinic;
use App\Models\User;

require_once app_path('Helper/constants.php');
class PharmacyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Pharmacy::class);

        $search = $request->get('search', '');

        $pharmacies = Pharmacy::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.pharmacies.index', compact('pharmacies', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Pharmacy::class);

        $campuses = Campus::pluck('name', 'id');
        $users=User::pluck('name','id');
        $clinics=Clinic::pluck('name','id');

        return view('app.pharmacies.create', compact('campuses','users','clinics'));
    }

    /**
     * @param \App\Http\Requests\PharmacyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PharmacyStoreRequest $request)
    {
        // dd($request);
        $this->authorize('create', Pharmacy::class);
        $validated=

        $validated = $request->validated();
        $validated['clinic_id']=$request->clinic_id;
     //   dd($validated);
        $pharmacy = Pharmacy::create($validated);

        return redirect()
            ->route('pharmacies.index', $pharmacy)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pharmacy $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pharmacy $pharmacy)
    {
        $this->authorize('view', $pharmacy);

        return view('app.pharmacies.show', compact('pharmacy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pharmacy $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Pharmacy $pharmacy)
    {
        $this->authorize('update', $pharmacy);

        $campuses = Campus::pluck('name', 'id');

        $users=User::pluck('name','id');
        $clinics=Clinic::pluck('name','id');
        return view('app.pharmacies.edit', compact('pharmacy', 'campuses','users','clinics'));
    }

    /**
     * @param \App\Http\Requests\PharmacyUpdateRequest $request
     * @param \App\Models\Pharmacy $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function update(PharmacyUpdateRequest $request, Pharmacy $pharmacy)
    {
        $this->authorize('update', $pharmacy);

        $validated = $request->validated();

        $pharmacy->update($validated);

        return redirect()
            ->route('pharmacies.edit', $pharmacy)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pharmacy $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Pharmacy $pharmacy)
    {
        $this->authorize('delete', $pharmacy);

        $pharmacy->delete();

        return redirect()
            ->route('pharmacies.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
