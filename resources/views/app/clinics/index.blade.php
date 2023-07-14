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
                    @can('create', App\Models\Clinic::class)
                        <a href="{{ route('clinics.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.clinics.index_title')</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.name')
                                </th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.code_clinic')
                                </th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.description')
                                </th>
                                <th class="text-right">
                                    @lang('crud.clinics.inputs.lat')
                                </th>
                                <th class="text-right">
                                    @lang('crud.clinics.inputs.long')
                                </th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.campus_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.collage_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.status')
                                </th>
                                <th class="text-left">
                                    @lang('crud.clinics.inputs.is_active')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clinics  as $key =>  $clinic)
                                <tr>

                                    <td> {{ $key + 1 }}
                                    <td>{{ $clinic->name ?? '-' }}</td>
                                    <td>{{ $clinic->code_clinic ?? '-' }}</td>
                                    <td>{{ $clinic->description ?? '-' }}</td>
                                    <td>{{ $clinic->lat ?? '-' }}</td>
                                    <td>{{ $clinic->long ?? '-' }}</td>
                                    <td>
                                        {{ optional($clinic->campus)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($clinic->collage)->name ?? '-' }}
                                    </td>
                                    <td>{{ $clinic->status ?? '-' }}</td>
                                    <td>{{ $clinic->is_active ?? '-' }}</td>
                                    <td class="text-center">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $clinic)
                                                <a href="{{ route('clinics.edit', $clinic) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                @endcan @can('view', $clinic)
                                                <a href="{{ route('clinics.show', $clinic) }}">
                                                    <button type="button" class="btn btn-sm btn-outline-primary mx-1">
                                                        <i class="icon ion-md-eye"></i> Show
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $clinic)
                                                <form action="{{ route('clinics.destroy', $clinic) }}" method="POST"
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
                                    <td colspan="10">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">{!! $clinics->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
