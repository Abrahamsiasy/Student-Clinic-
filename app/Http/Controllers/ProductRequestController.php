<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Models\Store;
use App\Models\Clinic;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductRequest;
use App\Http\Requests\ProductRequestStoreRequest;
use App\Http\Requests\ProductRequestUpdateRequest;
use App\Models\Item;
use App\Models\ItemsInPharmacy;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\StoresToPharmacy;
use App\Models\StoreUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Illuminate\Support\Carbon;

require_once app_path('Helper/constants.php');
class ProductRequestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if (Auth::user()->can('store.request.*')) {

            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            // dd($storeUser);
            if ($storeUser == null) {
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();


            $search = $request->get('search', '');

            $productRequests = ProductRequest::where('store_id', $storeUser->store_id)->where('status', 'Requested')->search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view(
                'app.product_requests.index',
                compact('productRequests', 'search')
            );
        } else if (Auth::user()->can('pharmacy.products.*')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();
            // dd($pharmacy->id);

            $search = $request->get('search', '');
            $productRequests = ProductRequest::where('pharmacy_id', $pharmacy->id)->search($search)->where('status', "Requested")
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view(
                'app.product_requests.index',
                compact('productRequests', 'search')
            );
        }


        $this->authorize('view-any', ProductRequest::class);

        $search = $request->get('search', '');

        $productRequests = ProductRequest::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.product_requests.index',
            compact('productRequests', 'search')
        );
    }


    public function create(Request $request)
    {
        if (Auth::user()->can('pharmacy.products.request')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $clinics = Clinic::pluck('name', 'id');
            // dd(StoresToPharmacy::where('pharmacy_id', $pharmacy->id)->pluck('store_id')->pluck('name', 'id'));
            $products = Product::where('store_id', StoresToPharmacy::where('pharmacy_id', $pharmacy->id)->pluck('store_id'))->pluck('name', 'id');
            $storeToPharmacy = (StoresToPharmacy::where('pharmacy_id', $pharmacy->id))->get();
            $stores = array();
            foreach ($storeToPharmacy as $value) {
                $s = Store::where('id', $value->store_id)->first();


                array_push($stores, $s);
            }

            return view(
                'app.product_requests.create',
                compact('clinics', 'products', 'stores')
            );
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');

    }


    public function store(ProductRequestStoreRequest $request)
    {

        if (Auth::user()->can('pharmacy.products.request')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();


            $validated = $request->validated();
            // dd($validated);
            $validated['pharmacy_id'] = $pharmacy->id;
            $validated['status'] = "Requested";
            // dd($validated);
            $productRequest = ProductRequest::create($validated);
            // dd($productRequest);
            return redirect()
                ->route('product-requests.edit', $productRequest)
                ->withSuccess(__('crud.common.created'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
        // $this->authorize('create', ProductRequest::class);

    }

    public function show(Request $request, ProductRequest $productRequest)
    {
        // $this->authorize('view', $productRequest);

        return view('app.product_requests.show', compact('productRequest'));
    }


    public function edit(Request $request, ProductRequest $productRequest)
    {

        if (Auth::user()->can('pharmacy.products.*')) {



            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $clinics = Clinic::pluck('name', 'id');
            $products = Product::where('store_id', StoresToPharmacy::where('pharmacy_id', $pharmacy->id)->pluck('store_id'))->pluck('name', 'id');
            $storeToPharmacy = (StoresToPharmacy::where('pharmacy_id', $pharmacy->id))->get();
            $stores = array();
            foreach ($storeToPharmacy as $value) {
                $s = Store::where('id', $value->store_id)->first();


                array_push($stores, $s);
            }

            $clinics = Clinic::pluck('name', 'id');
            $products = Product::pluck('name', 'id');

            return view(
                'app.product_requests.edit',
                compact('productRequest', 'clinics', 'products', 'stores')
            );
        }

        $this->authorize('update', $productRequest);
    }


    public function update(
        ProductRequestUpdateRequest $request,
        ProductRequest $productRequest
    ) {



        if (Auth::user()->can('pharmacy.products.*')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $validated = $request->validated();

            $productRequest->update($validated);

            return redirect()
                ->route('product-requests.edit', $productRequest)
                ->withSuccess(__('crud.common.saved'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
        // $this->authorize('update', $productRequest);

    }


    public function destroy(Request $request, ProductRequest $productRequest)
    {
        if (Auth::user()->can('pharmacy.products.*')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $productRequest->delete();
            return redirect()
                ->route('product-requests.index')
                ->withSuccess(__('crud.common.removed'));
        } else if (Auth::user()->can('store.request.*')) {
            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if ($storeUser == null) {
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();


            $productRequest->delete();

            return redirect()
                ->route('product-requests.index')
                ->withSuccess(__('crud.common.removed'));
        }
        // dd("aa");
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access l.');
    }

    public function approve(Request $request, ProductRequest $productRequest)
    {

        // dd($request);
        if (Auth::user()->can('store.request.*')) {
            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if ($storeUser == null) {
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();
            $totalAmountInStore = Item::where('product_id', $productRequest->product_id)->sum('number_of_units');
            if ($productRequest->amount > $totalAmountInStore) {

                // dd($productRequest->amount, $totalAmountInStore, $productRequest->product_id,"There is no available amount for the given request ");
                return redirect()->back()->with('error', 'There is no available amount for the given request');
            }


            $items = Item::where('product_id', $productRequest->product_id)->orderBy('expire_date')->get();
            // dd($items);
            $approvedAmount = $request->approvalAmount;
            foreach ($items as $item) {
                if ($item->number_of_units >= $approvedAmount) {
                    $t = ItemsInPharmacy::firstOrCreate(['item_id' => $item->id, 'pharmacy_id' => $productRequest->pharmacy_id]);
                    $t->count = $t->count + $approvedAmount;
                    $t->save();
                    $item->number_of_units = $item->number_of_units - $approvedAmount;
                    $item->save();
                    break;
                } else {
                    $approvedAmount = $approvedAmount - $item->number_of_units;
                    $t = ItemsInPharmacy::firstOrCreate(['item_id' => $item->id, 'pharmacy_id' => $productRequest->pharmacy_id]);
                    $t->count = $t->count + $item->number_of_units;
                    $t->save();

                    $item->number_of_units = 0;
                    $item->save();
                }
            }

            // dd($items);


            $productRequest->status = 'Approved';
            $productRequest->approval_amount = $request->approvalAmount;
            $productRequest->appoved_at=Carbon::now()->format('Y-m-d');
            $productRequest->save();

            return redirect()
                ->route('product-requests.index')
                ->withSuccess(__('crud.common.approved'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }

    public function toBeApprove(Request $request)
    {
        // if (Auth::user()->can('requests.list')) {

        $approvedRequests = ProductRequest::            where('status', 'Approved')
            ->orderByRaw("approved_at DESC, store_id ASC, pharmacy_id ASC")
            ->get();

        // dd(($approvedRequests));


        $groupofRequests = [];
        $i = 1;
        $request = [];
        if ($approvedRequests != null) {


            array_push($request, $approvedRequests[0]);

        }
        // dd($approvedRequests[0]);
        while ($i < count($approvedRequests)) {
            while (true) {
                if ($approvedRequests[$i]->store_id == $request[0]->store_id and
                 $approvedRequests[$i]->pharmacy_id == $request[0]->pharmacy_id and
                 $approvedRequests[$i]->approved_at == $request[0]->approved_at) {


                    array_push($request, $approvedRequests[$i]);

                    $i++;
                } else {

                    array_push($groupofRequests, $request);
                    $request = [];
                    array_push($request, $approvedRequests[$i]);
                    $i++;
                    break;
                }


            }

        }
        array_push($groupofRequests, $request);
        // dd($request);

        // dd($groupofRequests[0][0]->product);
        // foreach ($approvedRequests as $req) {

        // }
        // }

        return view('app.request_approve.index',compact('groupofRequests'));
        // abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');

    }
    public function approveByAdmin(Request $request)
    {
        $groupofRequest = json_decode($request->input('groupofRequest'));


        dd($groupofRequest);

        if (Auth::user()->can('requests.approve')) {

            // foreach ($groupofRequest as $request) {


            // }
        }

        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');

   }
    public function rejectByAdmin($groupofRequest)
    {
        if (Auth::user()->can('requests.approve')) {

            foreach ($groupofRequest as $request) {


            }
        }

        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');


    }

    // public function reject(Request $request ,ProductRequest $productRequest)
    // {
    //     if (Auth::user()->can('store.request.*')) {
    //         $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
    //         if($storeUser==null){
    //             return back()->withError('Store user hasn\'t been assigned to any store yet ');
    //         }
    //         $store = Store::where('id', $storeUser->store_id)->first();
    //         $products = Product::where('store_id', $store->id);

    //         $productRequest->status = 'Rejected';
    //         $productRequest->save();

    //         return redirect()
    //             ->route('product-requests.index')
    //             ->withSuccess(__('crud.common.rejected'));
    //     }
    //     abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    // }



    public function reject(Request $request, ProductRequest $productRequest)
    {

        // dd($request);
        if (Auth::user()->can('store.request.*')) {
            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if ($storeUser == null) {
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();
            $products = Product::where('store_id', $store->id);

            $productRequest->reason_of_rejection = $request->reason;
            $productRequest->status = 'Rejected';
            $productRequest->rejected_at = Carbon::now()->format('Y-m-d');
            $productRequest->save();

            return redirect()
                ->route('product-requests.index')
                ->withSuccess(__('crud.common.rejected'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }


    public function sentRequests(Request $request)
    {
        // dd(Auth::user()->hasRole(Constants::PHARMACY_USER));
        if (Auth::user()->can('pharmacy.products.*')) {
            $pharmacyUser = PharmacyUser::where('user_id', Auth::user()->id)->first();
            if ($pharmacyUser == null) {
                return back()->withError('Pharmacist hasn\'t been assigned to any pharmacy yet ');
            }
            $pharmacy = Pharmacy::where('id', $pharmacyUser->pharmacy_id)->first();

            $searchApproved = $request->get('searchApproved', '');
            $ApprovedProductRequests = ProductRequest::where('pharmacy_id', $pharmacy->id)->where('status', "Approved")->orderBy('updated_at', 'desc')->search($searchApproved)
                ->latest()
                ->paginate(5)
                ->withQueryString();
            $RequestedSearch = $request->get('search', '');
            $RequestedProductRequests = ProductRequest::where('pharmacy_id', $pharmacy->id)->where('status', "Requested")->orderBy('updated_at', 'desc')->search($RequestedSearch)
                ->latest()
                ->paginate(5)
                ->withQueryString();
            $searchRejected = $request->get('searchRejected', '');
            $RejectedProductRequests = ProductRequest::where('pharmacy_id', $pharmacy->id)->where('status', "Rejected")->orderBy('updated_at', 'desc')->search($searchRejected)
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view(
                'app.product_requests.sentRequests',
                compact('ApprovedProductRequests', 'RequestedProductRequests', 'RejectedProductRequests', 'searchApproved', 'RequestedSearch', 'searchRejected')
            );
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }


    public function recordsOfRequests(Request $request)
    {
        if (Auth::user()->can('store.request.*')) {

            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if ($storeUser == null) {
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            // dd($storeUser);
            $store = Store::where('id', $storeUser->store_id)->first();




            ////////////////////////////////////////////////////////////////////////


            $searchApproved = $request->get('searchApproved', '');

            $ApprovedRequests = ProductRequest::where('store_id', $storeUser->store_id)->where('status', 'Approved')->orderBy('updated_at', 'desc')->search($searchApproved)
                ->latest()
                ->paginate(5)
                ->withQueryString();
            // dd($ApprovedRequests[0]->pharmacy);
            $searchRejected = $request->get('searchRejected', '');

            $RejectedRequests = ProductRequest::where('store_id', $storeUser->store_id)->where('status', 'Rejected')->orderBy('updated_at', 'desc')->search($searchRejected)
                ->latest()
                ->paginate(5)
                ->withQueryString();
            // dd($RejectedRequests[0]->pharmacy());
            ///////////////////////////////////////////////////////////////////////


            $search = $request->get('search', '');

            $productRequests = ProductRequest::where('store_id', $storeUser->store_id)->where('status', 'Requested')->orderBy('updated_at', 'desc')->search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view(
                'app.product_requests.recordsOfRequests',
                compact(
                    'productRequests',
                    'search',
                    'searchApproved',
                    'searchRejected',
                    'ApprovedRequests',
                    'RejectedRequests'
                )
            );
        }
    }
}
