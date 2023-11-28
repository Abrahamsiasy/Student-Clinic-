<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Models\Item;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\ItemsInPharmacy;
use App\Http\Requests\ItemsInPharmacyStoreRequest;
use App\Http\Requests\ItemsInPharmacyUpdateRequest;
use App\Models\PharmacyUser;
use Illuminate\Support\Facades\Auth;

require_once app_path('Helper/constants.php');
class ItemsInPharmacyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('view-any', ItemsInPharmacy::class);


        if (Auth::user()->can('pharmacy.products.*')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if($pharmacyUser==null){
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            // dd($pharmacyUser);
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $search = $request->get('search', '');


            $itemsInPharmacies = ItemsInPharmacy::where('pharmacy_id', $pharmacy->id)->search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view(
                'app.items_in_pharmacies.index',
                compact('itemsInPharmacies', 'search')
            );
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ItemsInPharmacy::class);

        $items = Item::pluck('batch_number', 'id');
        $pharmacies = Pharmacy::pluck('name', 'id');

        return view(
            'app.items_in_pharmacies.create',
            compact('items', 'pharmacies')
        );
    }

    /**
     * @param \App\Http\Requests\ItemsInPharmacyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemsInPharmacyStoreRequest $request)
    {
        $this->authorize('create', ItemsInPharmacy::class);

        $validated = $request->validated();

        $itemsInPharmacy = ItemsInPharmacy::create($validated);

        return redirect()
            ->route('items-in-pharmacies.edit', $itemsInPharmacy)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ItemsInPharmacy $itemsInPharmacy
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ItemsInPharmacy $itemsInPharmacy)
    {
        // $this->authorize('view', $itemsInPharmacy);

        return view('app.items_in_pharmacies.show', compact('itemsInPharmacy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ItemsInPharmacy $itemsInPharmacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ItemsInPharmacy $itemsInPharmacy)
    {
        $this->authorize('update', $itemsInPharmacy);

        $items = Item::pluck('batch_number', 'id');
        $pharmacies = Pharmacy::pluck('name', 'id');

        return view(
            'app.items_in_pharmacies.edit',
            compact('itemsInPharmacy', 'items', 'pharmacies')
        );
    }

    /**
     * @param \App\Http\Requests\ItemsInPharmacyUpdateRequest $request
     * @param \App\Models\ItemsInPharmacy $itemsInPharmacy
     * @return \Illuminate\Http\Response
     */
    public function update(
        ItemsInPharmacyUpdateRequest $request,
        ItemsInPharmacy $itemsInPharmacy
    ) {
        $this->authorize('update', $itemsInPharmacy);

        $validated = $request->validated();

        $itemsInPharmacy->update($validated);

        return redirect()
            ->route('items-in-pharmacies.edit', $itemsInPharmacy)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ItemsInPharmacy $itemsInPharmacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ItemsInPharmacy $itemsInPharmacy)
    {
        $this->authorize('delete', $itemsInPharmacy);

        $itemsInPharmacy->delete();

        return redirect()
            ->route('items-in-pharmacies.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
