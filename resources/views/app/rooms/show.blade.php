@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('rooms.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.rooms.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.rooms.inputs.name')</h5>
                        <span>{{ $room->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.rooms.inputs.description')</h5>
                        <span>{{ $room->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.rooms.inputs.status')</h5>
                        <span>{{ $room->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.rooms.inputs.is_active')</h5>
                        <span>{{ $room->is_active ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.rooms.inputs.clinic_id')</h5>
                        <span>{{ optional($room->clinic)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.rooms.inputs.encounter_id')</h5>
                        <span>{{ optional($room->encounter)->id ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('rooms.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Room::class)
                        <a href="{{ route('rooms.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        @can('view-any', App\Models\clinic_user_room::class)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title w-100 mb-2">Clinic Users</h4>

                    <livewire:room-clinic-users-detail :room="$room" />
                </div>
            </div>
        @endcan
    </div>
@endsection
