@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        @lang('crud.items_in_pharmacies.index_title')
                    </h4>
                </div>

                <div class="searchbar mt-4 mb-5">
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="input-group">
                                    <input id="indexSearch" type="text" name="search"
                                        placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                        class="form-control" autocomplete="off" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            {{-- @can('create', App\Models\ItemsInPharmacy::class) --}}
                            {{-- <a
                            href="{{ route('items-in-pharmacies.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a> --}}
                            {{-- @endcan --}}

                            <a href="{{ route('product-requests.create') }}" class="btn btn-primary">
                                <i class="icon ion-md-add"></i>
                                Request new
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                    Name
                                </th>
                                <th class="text-left">
                                    Catagory
                                </th>
                                <th class="text-left">
                                    Amount
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse($itemsInPharmacies as $itemsInPharmacy)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ optional($itemsInPharmacy->item->product)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($itemsInPharmacy->item->product->category)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $itemsInPharmacy->count ?? '-' }}

                                    </td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            {{-- @can('update', $itemsInPharmacy)
                                    <a
                                        href="{{ route('items-in-pharmacies.edit', $itemsInPharmacy) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $itemsInPharmacy)
                                    <a
                                        href="{{ route('items-in-pharmacies.show', $itemsInPharmacy) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $itemsInPharmacy)
                                    <form
                                        action="{{ route('items-in-pharmacies.destroy', $itemsInPharmacy) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan --}}


                                            <a href="{{ route('items-in-pharmacies.show', $itemsInPharmacy) }}">
                                                <button type="button" class="btn btn-light">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    {!! $itemsInPharmacies->render() !!}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
