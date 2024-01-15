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
                @can('create', App\Models\Role::class)
                    <a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#modal-default">
                        <i class="icon ion-md-add"></i> @lang('crud.common.create')
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">Gate List</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                Name
                            </th>
                            <th>
                                Scanner ID
                            </th>
                            <th>
                                Campus
                            </th>
                            <th>
                                Location
                            </th>
                            <th>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gateScanner  as $key =>  $gate)
                            <tr>

                                <td> {{ $key + 1 }}
                                <td>{{ $gate->gate_name}}</td>
                                <td>{{ $gate->scanner_id}}</td>
                                <td>{{ $gate->campus?->name}}</td>
                                <td><a href="{{ $gate->location ?? '-' }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-map-marker-alt"></i> Show location</a></td>
                                <td class="text-center">
                                    <div role="group" aria-label="Row Actions" class="btn-group">
                                        @can('update', $gate)
                                            <a href="{{ route('roles.edit', $gate) }}">
                                                <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            @endcan @can('view', $gate)
                                            <a href="{{ route('gate.show', $gate->id) }}" target="_blank">
                                                <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                    <i class="fa fa-eye"></i> Show
                                                </button>
                                            </a>
                                            @endcan 
                                            @can('delete', $gate)
                                            <form action="{{ route('roles.destroy', $gate) }}" method="POST"
                                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger mx-1">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('app.gate.create-modal')
@endsection
