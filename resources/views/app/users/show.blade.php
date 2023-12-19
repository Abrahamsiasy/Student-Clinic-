@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script>
        $(function() {
            $('.duallistbox').bootstrapDualListbox()
        })
    </script>
@endpush
@section('content')
<div class="">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('users.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.users.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.users.inputs.name')</h5>
                    <span>{{ $user->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.users.inputs.username')</h5>
                    <span>{{ $user->username ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.users.inputs.email')</h5>
                    <span>{{ $user->email ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.roles.name')</h5>
                    <div>
                        @forelse ($user->roles as $role)
                        <div class="badge badge-primary">{{ $role->name }}</div>
                        <br />
                        @empty - @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\User::class)
                <a href="{{ route('users.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    {{-- @can('view-any', App\Models\ClinicUser::class)
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title w-100 mb-2">Clinic Users</h4>

            <livewire:user-clinic-users-detail :user="$user" />
        </div>
    </div>
    @endcan --}}

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{ route('user.role.permission.update', ['user'=>$user->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="role">Select Role</label>
                        <select name="role" id="role" class="select2 form-control">
                            <option value=""></option>
                            @foreach ($roles as $role)

                                <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Direct Permission</label>
                        <select name="input_permissions[]" class="duallistbox" multiple="multiple">
                            <option value=""></option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}"
                                    {{ $user->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                                    {{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Assign Permission" class="btn btn-primary">
                    </div>
                </form>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
@endsection
