<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;
use Illuminate\Support\Facades\Auth;
class ProductItemsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        // dd("Here");
        // $this->authorize('view', $product);

        $search = $request->get('search', '');

        $items = $product
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        // dd("I am here");
        // $this->authorize('create', Item::class);
        if (Auth::user()->can('store.product.index')) {

            $validated = $request->validate([
                'batch_number' => ['nullable', 'max:255', 'string'],
                'expire_date' => ['nullable', 'date'],
                'brand' => ['nullable', 'max:255', 'string'],
                'supplier_name' => ['nullable', 'max:255', 'string'],
                'campany_name' => ['nullable', 'max:255', 'string'],
                'number_of_units' => ['nullable', 'numeric'],
                'number_of_unit_per_pack' => ['nullable', 'numeric'],
                'unit_type' => ['required', 'string'],
                'unit_price' => ['nullable', 'numeric'],
                'price_per_unit' => ['nullable', 'numeric'],
                'profit_margit' => ['nullable', 'numeric'],
            ]);

            $item = $product->items()->create($validated);

            return new ItemResource($item);
        }
        }


}
