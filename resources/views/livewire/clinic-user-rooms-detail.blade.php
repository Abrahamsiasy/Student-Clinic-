<div>
    <div class="mb-4">
        @can('create', App\Models\Room::class)
            <button class="btn btn-primary" data-toggle="modal" data-target="#clinicUserRoomModal">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.attach')
            </button>
        @endcan


        <div class="modal fade" id="clinicUserRoomModal" tabindex="-1" role="dialog"
            aria-labelledby="clinicUserRoomModalLabel" aria-hidden="true">
            <form action="{{ route('clinic-change-user-room') }}" method="post">
                @csrf
                <div class="modal-dialog" role="document">
                    <!-- Your modal content goes here -->
                    <form action="{{ route('clinic-change-user-room') }}" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $modalTitle }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div>
                                    <div class="col-12">
                                        <label for="room_id">Room: </label>
                                        <input type="hidden" name="clinic_user_id" value="{{ $clinicUser->id }}" />
                                        <select name="room_id" id="room_id" class="form-control select2">
                                            <option value="null" disabled>Please select the Clinic</option>
                                            @foreach ($roomsForSelect as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light float-left" data-dismiss="modal">
                                    <i class="icon ion-md-close"></i>
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>

    </div>

    <div class="table-responsive">
        <table class="table table-hover  table-sm table-condensed">
            <thead>
                <tr>
                    <th class="text-left">
                        @lang('crud.clinic_user_rooms.inputs.room_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            {{-- @dd($room_name); --}}
            @if ($room_name !== '-')
                <tbody class="text-gray-600">
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">{{ $room_name ?? '-' }}</td>
                        <td class="text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('delete-any', App\Models\Room::class)
                                    <button class="btn btn-sm btn-outline-danger mx-1"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach('{{ $room_id }}')">
                                        <i class="icon ion-md-trash"></i> Delete
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                </tbody>
            @endif
            @if ($room_name === '-')
                <h2>Please atach room to the user </h2>
            @endif
            <tfoot>
                {{-- <tr>
                    <td colspan="2">{{ $clinicUserRooms->render() }}</td>
                </tr> --}}
            </tfoot>
        </table>
    </div>
</div>
