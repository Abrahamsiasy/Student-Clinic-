<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Helper\ProductHelper;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\StoreUser;
use Illuminate\Support\Facades\Auth;

require_once app_path('Helper/constants.php');
class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->can('store.product.index')) {
            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if($storeUser==null){
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();
            // dd($products);
            $search = $request->get('search', '');
            $products = Product::where('store_id', $store->id)->search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();
            return view('app.products.index', compact('products', 'search'));
        }
        return         $this->authorize('view-any', Product::class);



        $search = $request->get('search', '');

        $products = Product::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.products.index', compact('products', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        if (Auth::user()->can('store.product.create')) {
            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if($storeUser==null){
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();
            // dd($products);

            $categories = Category::pluck('name', 'id');
            $stores = Store::pluck('name', 'id');
            $search = $request->get('search', '');

            return view('app.products.create', compact('categories', 'stores', 'store'));


            $products = Product::where('store_id', $store->id)->search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();
            return view('app.products.index', compact('products', 'search'));
        }


        $this->authorize('create', Product::class);

        $categories = Category::pluck('name', 'id');
        $stores = Store::pluck('name', 'id');

        return view('app.products.create', compact('categories', 'stores'));
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        // dd($request->name);
        if (Auth::user()->can('store.product.create')) {
            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if($storeUser==null){
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();
            $validated = $request->validated();
            $validated['store_id'] = $store->id;
            $product = Product::firstOrCreate($validated);

            return redirect()
                ->route('products.edit', $product)
                ->withSuccess(__('crud.common.created'));
        }
        $this->authorize('create', Product::class);

        $validated = $request->validated();

        $product = Product::firstOrCreate($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        // $this->authorize('view', $product);
        if (Auth::user()->can('store.product.view')) {
            // $storeUser=StoreUser::where('user_id',Auth::user()->id)->first();
            // $store=Store::where('id',$storeUser->store_id)->first();
            // // dd($products);
            // $search = $request->get('search', '');
            // $products=Product::where('store_id',$store->id)->search($search)
            // ->latest()
            // ->paginate(5)
            // ->withQueryString();
            // return view('app.products.index', compact('products', 'search'));

            return view('app.products.show', compact('product'));
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        // $this->authorize('update', $product);

        $categories = Category::pluck('name', 'id');
        $stores = Store::pluck('name', 'id');

        return view(
            'app.products.edit',
            compact('product', 'categories', 'stores')
        );
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        // $this->authorize('update', $product);

        $validated = $request->validated();

        $product->update($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        // $this->authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function sync(ProductHelper $productHelper){


        if (Auth::user()->can('store.product.create')) {

            $storeUser = StoreUser::where('user_id', Auth::user()->id)->first();
            if($storeUser==null){
                return back()->withError('Store user hasn\'t been assigned to any store yet ');
            }
            $store = Store::where('id', $storeUser->store_id)->first();
            $productHelper->syncProducts($store);
            return redirect()->back()->withSuccess(__('Product Synced successfully'));

        }
        else{
            return $this->authorize('view-any', Product::class);

        }
    }
}
