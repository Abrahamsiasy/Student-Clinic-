<div>
    <div class="mb-4">
        @can('create', App\Models\Room::class)
            <button class="btn btn-primary" wire:click="newRoom">
                <i class="icon ion-md-add"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Room::class)
            <button class="btn btn-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="icon ion-md-trash"></i> Delete
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal id="clinic-rooms-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="room.name" label="Name" wire:model="room.name" maxlength="255"
                            placeholder="Name"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.textarea name="room.description" label="Description" wire:model="room.description"
                            maxlength="255"></x-inputs.textarea>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="room.status" label="Status" wire:model="room.status" maxlength="255"
                            placeholder="Status"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.text name="room.is_active" label="Is Active" wire:model="room.is_active"
                            maxlength="255" placeholder="Is Active"></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12">
                        <x-inputs.select name="room.encounter_id" label="Encounter" wire:model="room.encounter_id">
                            <option value="null" disabled>Please select the Encounter</option>
                            @foreach ($encountersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                </div>
            </div>

            @if ($editing)
            @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-light float-left" wire:click="$toggle('showingModal')">
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="text-left">
                        @lang('crud.clinic_rooms.inputs.name')
                    </th>
                    <th class="text-left">
                        @lang('crud.clinic_rooms.inputs.description')
                    </th>
                    <th class="text-left">
                        @lang('crud.clinic_rooms.inputs.status')
                    </th>
                    <th class="text-left">
                        @lang('crud.clinic_rooms.inputs.is_active')
                    </th>
                    <th class="text-left">
                        @lang('crud.clinic_rooms.inputs.encounter_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($rooms as $room)
                    <tr class="hover:bg-gray-100">
                        <td class="text-left">
                            <input type="checkbox" value="{{ $room->id }}" wire:model="selected" />
                        </td>
                        <td class="text-left">{{ $room->name ?? '-' }}</td>
                        <td class="text-left">{{ $room->description ?? '-' }}</td>
                        <td class="text-left">{{ $room->status ?? '-' }}</td>
                        <td class="text-left">{{ $room->is_active ?? '-' }}</td>
                        <td class="text-left">
                            {{ optional($room->encounter)->id ?? '-' }}
                        </td>
                        <td class="text-right">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $room)
                                    <button type="button" class="btn btn-light"
                                        wire:click="editRoom({{ $room->id }})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">{{ $rooms->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
