@extends('layouts.app')

@section('content')
    <div class="">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    @can('store.product.create')
                        <a href="{{ route('sync.product') }}" class="btn btn-success">
                            <i class="nav-icon fa fa-sync-alt"></i>Sync
                        </a>
                    @endcan
                    @can('store.product.create')
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Products List</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                    @lang('crud.products.inputs.name')
                                </th>
                                <th class="text-left">
                                    @lang('crud.products.inputs.category_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.products.inputs.store_id')
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
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $product->name ?? '-' }}</td>
                                    <td>
                                        {{ optional($product->category)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($product->store)->name ?? '-' }}
                                    </td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('store.product.update')
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="btn btn-sm btn-outline-primary mx-1">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                @endcan @can('store.product.view')
                                                {{-- <a
                                        href="{{ route('products.show', $product) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a> --}}

                                                <a href="{{ route('products.show', $product) }}"
                                                    class="btn btn-sm btn-outline-primary mx-1">
                                                    <i class="icon ion-md-eye"></i> Show

                                                </a>
                                                @endcan @can('store.product.delete')
                                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger mx-1">
                                                        <i class="icon ion-md-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endcan
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
                                <td colspan="4">{!! $products->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
