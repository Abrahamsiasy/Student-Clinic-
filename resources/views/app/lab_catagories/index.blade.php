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
                    @can('create', App\Models\LabCatagory::class)
                        <a href="{{ route('lab-catagories.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        @lang('crud.lab_catagories.index_title')
                    </h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover  table-sm table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                    @lang('crud.lab_catagories.inputs.lab_name')
                                </th>
                                <th class="text-left">
                                    @lang('crud.lab_catagories.inputs.lab_desc')
                                </th>

                                <th class="text-left">
                                  Total labs
                                </th>

                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($labCatagories  as $key =>  $labCatagory)
                                <tr>

                                    <td> {{ $key + 1 }}
                                    <td>{{ $labCatagory->lab_name ?? '-' }}</td>
                                    <td>{{ $labCatagory->lab_desc ?? '-' }}</td>
                                    <td>{{ $labCatagory->labTests->count() }} </td>
                                    <td class="text-center">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                      
                                            @can('view', $labCatagory)
                                            <a href="{{ route('lab-catagories.show', $labCatagory) }}">
                                                <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                    <i class="fa fa-list"></i> Details
                                                </button>
                                            </a>
                                            @endcan

                                            @can('update', $labCatagory)
                                                <a href="{{ route('lab-catagories.edit', $labCatagory) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-info mx-1">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                           
                                                @endcan
                                                 @can('delete', $labCatagory)
                                                <form action="{{ route('lab-catagories.destroy', $labCatagory) }}"
                                                    method="POST"
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
                                    <td colspan="3">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    {!! $labCatagories->render() !!}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
