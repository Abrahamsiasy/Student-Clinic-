<?php

namespace App\Http\Controllers;

use App\Constants;

use App\Models\Campus;
use App\Models\Pharmacy;
use App\Models\StoresToPharmacy;
use Illuminate\Http\Request;
use App\Http\Requests\PharmacyStoreRequest;
use App\Http\Requests\PharmacyUpdateRequest;
use App\Models\Clinic;
use App\Models\PharmacyUser;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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

        // $campuses = Campus::pluck('name', 'id');
        $users=User::pluck('name','id');
        $clinics=Clinic::pluck('name','id');
        $stores=Store::pluck('name','id');
        return view('app.pharmacies.create', compact('users','clinics','stores'));
    }

    /**
     * @param \App\Http\Requests\PharmacyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PharmacyStoreRequest $request)
    {

        $this->authorize('create', Pharmacy::class);


        $validated = $request->validated();
        // $validated['clinic_id']=$request->clinic_id;
        // $validated['store_id']=$request->store_id;

        $pharmacy = Pharmacy::create($validated);

        StoresToPharmacy::create(['pharmacy_id'=>$pharmacy->id,'store_id'=>$validated['store_id']]);

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
        $stores=Store::pluck('name','id');
        return view('app.pharmacies.edit', compact('pharmacy', 'campuses','users','clinics','stores'));
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
        $validated['store_id']=$request->store_id;
        $validated['clinic_id']=$request->clinic_id;

        $pharmacy->update($validated);
        StoresToPharmacy::where('pharmacy_id',$pharmacy->id)->update(['store_id'=>$validated['store_id']]);
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


    public function studentHistory(Request $request){

        if (Auth::user()->can('pharmacy.history.*')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if($pharmacyUser==null){
                return back()->withError('Pharmacist has been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();
            // dd($pharmacy->id);

            return view('app.history.pharmacy_student_history');
        }

    }
}
