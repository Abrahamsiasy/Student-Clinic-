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
use App\Models\ProductResponse;
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

            $productRequest->to_be_approved = $request->approvalAmount;





            $productRequest->status = 'Accepted';
            $productRequest->approval_amount = $request->approvalAmount;
            $productRequest->approved_at = Carbon::now()->format('Y-m-d');
            $productRequest->save();

            return redirect()
                ->route('product-requests.index')
                ->withSuccess(__('crud.common.approved'));
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }

    ///This function will fetch the requests that has been accepted by the stores from pharmacies but yet haven't been approved by the approved
    public function toBeApprove(Request $request)
    {
        // if (Auth::user()->can('requests.list')) {

        $acceptedRequests = ProductRequest::where('status', 'Accepted')
            ->orderByRaw("approved_at DESC, store_id ASC, pharmacy_id ASC")
            ->get();

        // dd(($acceptedRequests));


        $groupofRequests = [];
        $i = 1;
        $requests = [];
        if (count($acceptedRequests)) {


            array_push($requests, $acceptedRequests[0]);
        }

        while ($i < count($acceptedRequests)) {
            while (true and $i < count($acceptedRequests)) {
                if (
                    $acceptedRequests[$i]->store_id == $requests[0]->store_id and
                    $acceptedRequests[$i]->pharmacy_id == $requests[0]->pharmacy_id and
                    $acceptedRequests[$i]->approved_at == $requests[0]->approved_at
                ) {


                    array_push($requests, $acceptedRequests[$i]);

                    $i++;
                } else {

                    array_push($groupofRequests, $requests);
                    $requests = [];
                    array_push($requests, $acceptedRequests[$i]);
                    $i++;
                    break;
                }
            }
        }
        if ($requests) {

            array_push($groupofRequests, $requests);
        }


        return view('app.group_requests.index', compact('groupofRequests'));
        // abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');

    }
    ///This function will approve the requests that has been accepted by the stores from pharmacies but yet haven't been approved by the approved
    public function approveByAdmin(Request $request)
    {
        if (Auth::user()->can('groupRequest.approve')) {

            $approver_id=Auth::user()->id;
            $groupofRequest = json_decode($request->input('groupofRequest'));


            // dd($groupofRequest);
            $latestRecord = ProductResponse::latest()->first();
            if ($latestRecord) {
                $newTinNumber = str_pad((int)$latestRecord->tin_number + 1, strlen($latestRecord->tin_number), '0', STR_PAD_LEFT);
            } else {
                // If no rows are found, start with '0001' or any initial value
                $newTinNumber = '00001';
            }

            foreach ($groupofRequest as $re) {
                $productResponse = new ProductResponse();
                $productResponse->tin_number = $newTinNumber;
                $productResponse->status = 1;
                $productResponse->product_request_id = $re->id;
                $productResponse->approved_by=$approver_id;
                $productResponse->approved_at = Carbon::now()->format('Y-m-d');
                $productResponse->save();


                $items = Item::where('product_id', $re->product_id)->orderBy('expire_date')->get();
                // dd($items);
                $approvedAmount = $re->approval_amount;
                foreach ($items as $item) {
                    if ($item->number_of_units >= $approvedAmount) {
                        $t = ItemsInPharmacy::firstOrCreate(['item_id' => $item->id, 'pharmacy_id' => $re->pharmacy_id]);
                        $t->count = $t->count + $approvedAmount;
                        $t->save();
                        $item->number_of_units = $item->number_of_units - $approvedAmount;
                        $item->save();
                        break;
                    } else {
                        $approvedAmount = $approvedAmount - $item->number_of_units;
                        $t = ItemsInPharmacy::firstOrCreate(['item_id' => $item->id, 'pharmacy_id' => $re->pharmacy_id]);
                        $t->count = $t->count + $item->number_of_units;
                        $t->save();

                        $item->number_of_units = 0;
                        $item->save();
                    }
                }

                $p = ProductRequest::find($re->id);
                // dd($p);
                $p->status = "Approved";
                $p->save();
            }
            return redirect()
                ->route('groupRequest.index')
                ->withSuccess(__('A group of request has been approved successfully'));

            // foreach ($groupofRequest as $request) {


            // }
        }

        abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized access.');
    }
    ///This function will reject the requests that has been accepted by the stores from pharmacies but yet haven't been approved by the approved
    public function rejectByAdmin(Request $request)
    {
        $groupofRequest = json_decode($request->input('groupofRequest'));

        if (Auth::user()->can('groupRequest.reject')) {
            $approved_by=Auth::user()->id;
            foreach ($groupofRequest as $re) {
                $productResponse = new ProductResponse();
                $productResponse->status = 0;
                $productResponse->product_request_id = $re->id;
                $productResponse->approved_by=$approved_by;
                $productResponse->rejected_at = Carbon::now()->format('Y-m-d');

                $productResponse->save();


                $p = ProductRequest::find($re->id);
                // dd($p);
                $p->status = "Rejected";
                $p->save();
            }

            return redirect()
                ->route('groupRequest.index')
                ->withSuccess(__('A group of request has been rejected successfully'));
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
