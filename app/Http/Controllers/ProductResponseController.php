<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Models\Store;
use App\Models\Clinic;
use App\Models\Product;
use Illuminate\Http\Request;

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
class ProductResponseController extends Controller
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






    public function approved(Request $request){

        $tinNumber = $request->input('search');

        $latestResponses = ProductResponse::when($tinNumber, function ($query) use ($tinNumber) {
            return $query->where('tin_number', $tinNumber);
        })->get();
        $groupedResponses = $latestResponses->groupBy('tin_number');

        $perPage = 5; // Number of items per page
        $page = request()->get('page', 1); // Get the current page from the request or default to 1

        // Use the 'forPage' method to get a specific page from the grouped collection
        $paginatedGroupedResponses = $groupedResponses->forPage($page, $perPage);
        // Create a LengthAwarePaginator instance
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedGroupedResponses,
            $groupedResponses->count(), // Total number of items in the original grouped collection
            $perPage, // Number of items per page
            $page, // Current page
            ['path' => request()->url()] // Additional options for the paginator
        );


        // foreach($paginator as $key=>$datas){
        //     foreach($datas as $data){
        //         dump($data->approvedBy                ->name);
        //     }
        // }
// dd($paginator);

        return view('app.group_requests.approved', compact('paginator'));


    }










}
