<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductItemsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public Item $item;
    public $itemExpireDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Item';

    protected $rules = [
        'item.batch_number' => ['required', 'max:255', 'string'],
        'itemExpireDate' => ['required', 'date'],
        'item.brand' => ['nullable', 'max:255', 'string'],
        'item.supplier_name' => ['nullable', 'max:255', 'string'],
        'item.campany_name' => ['nullable', 'max:255', 'string'],
        'item.number_of_units' => ['required', 'numeric'],
        'item.number_of_unit_per_pack' => ['nullable', 'numeric'],
        'item.unit_type' => ['nullable', 'string'],
        'item.unit_price' => ['nullable', 'numeric'],
        'item.price_per_unit' => ['nullable', 'numeric'],
        'item.profit_margit' => ['nullable', 'numeric'],
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->resetItemData();
    }

    public function resetItemData()
    {
        $this->item = new Item();

        $this->itemExpireDate = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newItem()
    {

        $this->editing = false;
        $this->modalTitle = trans('crud.product_items.new_title');
        $this->resetItemData();

        $this->showModal();
    }

    public function editItem(Item $item)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_items.edit_title');
        $this->item = $item;

        $this->itemExpireDate = optional($this->item->expire_date)->format(
            'Y-m-d'
        );

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->item->product_id) {
            // $this->authorize('create', Item::class);

            $this->item->product_id = $this->product->id;
        } else {
            // $this->authorize('update', $this->item);
        }

        $this->item->expire_date = \Carbon\Carbon::make($this->itemExpireDate);

        $this->item->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        // $this->authorize('delete-any', Item::class);

        Item::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetItemData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->items as $item) {
            array_push($this->selected, $item->id);
        }
    }

    public function render()
    {
        return view('livewire.product-items-detail', [
            'items' => $this->product->items()->paginate(20),
        ]);
    }
}
