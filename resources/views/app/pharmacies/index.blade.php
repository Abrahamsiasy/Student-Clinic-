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
                    @can('create', App\Models\Pharmacy::class)
                        <a href="{{ route('pharmacies.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.pharmacies.index_title')</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                    @lang('crud.pharmacies.inputs.name')
                                </th>
                                <th class="text-left">
                                    Admin Name
                                </th>
                                {{-- <th class="text-left">
                                @lang('crud.pharmacies.inputs.campus_id')
                            </th> --}}
                                <th class="text-left">
                                    Store
                                </th>
                                <th class="text-left">
                                    @lang('crud.pharmacies.inputs.status')
                                </th>
                                <th class="text-left">
                                    @lang('crud.pharmacies.inputs.description')
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
                            @forelse($pharmacies as $pharmacy)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $pharmacy->name ?? '-' }}</td>
                                    <td>{{ $pharmacy->admin->name ?? '-' }}</td>
                                    {{-- <td>
                                {{ optional($pharmacy->campus)->name ?? '-' }}
                            </td> --}}
                                    <td>
                                        {{ optional($pharmacy->store)->name ?? '-' }}
                                    </td>
                                    <td>
                                        @if ($pharmacy->status)
                                            Working
                                        @endif
                                        Not Working
                                    </td>
                                    <td>{{ $pharmacy->description ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $pharmacy)
                                                <a href="{{ route('pharmacies.edit', $pharmacy) }}">
                                                   <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                @endcan @can('view', $pharmacy)
                                                <a href="{{ route('pharmacies.show', $pharmacy) }}">
                                                   <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="icon ion-md-eye"></i> Show
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $pharmacy)
                                                <form action="{{ route('pharmacies.destroy', $pharmacy) }}" method="POST"
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
                                    <td colspan="6">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">{!! $pharmacies->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
