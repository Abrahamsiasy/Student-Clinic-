<div>
    <div class="mb-4">
        {{-- @can('create', App\Models\Item::class) --}}
        <button class="btn btn-primary" wire:click="newItem">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        {{-- @endcan @can('delete-any', App\Models\Item::class) --}}
        <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
            <i class="icon ion-md-trash"></i>
            @lang('crud.common.delete_selected')
        </button>
        {{-- @endcan --}}
    </div>

    <x-modal id="product-items-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="item.batch_number" label="Batch Number" wire:model="item.batch_number"
                            maxlength="255" placeholder="Batch Number"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.date name="itemExpireDate" label="Expire Date" wire:model="itemExpireDate"
                            max="255"></x-inputs.date>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="item.brand" label="Brand" wire:model="item.brand" maxlength="255"
                            placeholder="Brand"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="item.supplier_name" label="Supplier Name" wire:model="item.supplier_name"
                            maxlength="255" placeholder="Supplier Name"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="item.campany_name" label="Campany Name" wire:model="item.campany_name"
                            maxlength="255" placeholder="Campany Name"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="item.number_of_units" label="Number Of Units"
                            wire:model="item.number_of_units" max="255" step="0.01"
                            placeholder="Number Of Units"></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="col-sm-12">

                        <x-inputs.select name="item.unit_type" label="Unit Type" wire:model="item.unit_type"
                            placeholder="Unit Type">

                            <option value="">select unit type</option>
                            <option value="Strip">Strip</option>
                            <option value="Bottle">Bottle</option>
                            <option value="Vial">Vial</option>
                            <option value="Ampule">Ampule</option>
                            <option value="Tube">Tube</option>
                            <option value="Tin">Tin</option>
                            <option value="Sachet">Sachet</option>
                            <option value="Dozen">Dozen</option>

                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="item.number_of_unit_per_pack" label="Number Of Unit Per Pack"
                            wire:model="item.number_of_unit_per_pack" max="255" step="0.01"
                            placeholder="Number Of Unit Per Pack"></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="item.unit_price" label="Unit Price" wire:model="item.unit_price"
                            max="255" step="0.01" placeholder="Unit Price"></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="item.price_per_unit" label="Price Per Unit"
                            wire:model="item.price_per_unit" max="255" step="0.01"
                            placeholder="Price Per Unit"></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.number name="item.profit_margit" label="Profit Margit" wire:model="item.profit_margit"
                            max="255" step="0.01" placeholder="Profit Margit"></x-inputs.number>
                    </x-inputs.group>
                </div>
            </div>

            @if ($editing)
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-light float-left" wire:click="$toggle('showingModal')">
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                        @lang('crud.product_items.inputs.batch_number')
                    </th>
                    <th class="text-left">
                        @lang('crud.product_items.inputs.expire_date')
                    </th>
                    <th class="text-left">
                        @lang('crud.product_items.inputs.brand')
                    </th>
                    <th class="text-left">
                        @lang('crud.product_items.inputs.supplier_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.product_items.inputs.campany_name')
                    </th>
                    <th class="text-right">
                        @lang('crud.product_items.inputs.number_of_units')
                    </th>
                    <th class="text-right">
                        Unit Type
                    </th>
                    <th class="text-right">
                        @lang('crud.product_items.inputs.number_of_unit_per_pack')
                    </th>
                    <th class="text-right">
                        @lang('crud.product_items.inputs.unit_price')
                    </th>
                    <th class="text-right">
                        @lang('crud.product_items.inputs.price_per_unit')
                    </th>
                    <th class="text-right">
                        @lang('crud.product_items.inputs.profit_margit')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($items as $item)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $item->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">{{ $item->batch_number ?? '-' }}</td>
                        <td class="text-left">{{ $item->expire_date ?? '-' }}</td>
                        <td class="text-left">{{ $item->brand ?? '-' }}</td>
                        <td class="text-left">{{ $item->supplier_name ?? '-' }}</td>
                        <td class="text-left">{{ $item->campany_name ?? '-' }}</td>
                        <td class="text-right">
                            {{ $item->number_of_units ?? '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->unit_type ?? '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->number_of_unit_per_pack ?? '-' }}
                        </td>
                        <td class="text-right">{{ $item->unit_price ?? '-' }}</td>
                        <td class="text-right">
                            {{ $item->price_per_unit ?? '-' }}
                        </td>
                        <td class="text-right">
                            {{ $item->profit_margit ?? '-' }}
                        </td>
                        <td class="text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                {{-- @can('update', $item) --}}
                                <button type="button" class="btn btn-light"
                                    wire:click="editItem({{ $item->id }})">
                                    <i class="icon ion-md-create"></i>
                                </button>
                                {{-- @endcan --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11">{{ $items->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
