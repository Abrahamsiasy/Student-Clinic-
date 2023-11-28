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
                    {{-- @can('create', App\Models\Store::class)
                        <a href="{{ route('stores.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan --}}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Store Users</h4>
                </div>

                <div class="table-responsive">
                      <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                   User
                                </th>
                                <th class="text-left">
                                   Assigned Store
                                </th>
                                {{-- <th class="text-left">
                                    @lang('crud.stores.inputs.description')
                                </th>
                                <th class="text-left">
                                    @lang('crud.stores.inputs.status')
                                </th> --}}
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse($store_users as $user)
                                <tr>
                                    <th>{{ $i++ }}</th>
                                    <td>{{ $user->name ?? '-' }}</td>
                                    <td>{{ $user->storeUser->name ?? 'Not Assigned' }}</td>
                                    {{-- <td>{{ $store->description ?? '-' }}</td>
                                    <td>{{ $store->status ?? '-' }}</td> --}}
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $user)
                                                <a href="{{ route('stores.edit', $user) }}">
                                                   <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                @endcan @can('view', $user)
                                                <a href="{{ route('stores.show', $user) }}">
                                                   <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="icon ion-md-eye"></i> Show
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $user)
                                                <form action="{{ route('stores.destroy', $user) }}" method="POST"
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
                                    <td colspan="5">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">{!! $store_users->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Pharmacy Users</h4>
                </div>

                <div class="table-responsive">
                      <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                   User
                                </th>
                                <th class="text-left">
                                   Assigned Pharmacy
                                </th>
                                {{-- <th class="text-left">
                                    @lang('crud.stores.inputs.description')
                                </th>
                                <th class="text-left">
                                    @lang('crud.stores.inputs.status')
                                </th> --}}
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse($pharmacy_users as $user)
                                <tr>
                                    <th>{{ $i++ }}</th>
                                    <td>{{ $user->name ?? '-' }}</td>
                                    <td>{{ $user->pharmacyUsers->name ?? 'Not Assigned' }}</td>
                                    {{-- <td>{{ $store->description ?? '-' }}</td>
                                    <td>{{ $store->status ?? '-' }}</td> --}}
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $user)
                                                <a href="{{ route('stores.edit', $user) }}">
                                                   <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                @endcan @can('view', $user)
                                                <a href="{{ route('stores.show', $user) }}">
                                                   <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="icon ion-md-eye"></i> Show
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $user)
                                                <form action="{{ route('stores.destroy', $user) }}" method="POST"
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
                                    <td colspan="5">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">{!! $pharmacy_users->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
