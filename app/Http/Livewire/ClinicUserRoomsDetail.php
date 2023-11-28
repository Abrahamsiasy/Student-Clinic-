<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\ClinicUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClinicUserRoomsDetail extends Component
{
    use AuthorizesRequests;

    public ClinicUser $clinicUser;
    public Room $room;
    public $roomsForSelect = [];
    public $room_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Room';

    protected $rules = [
        'room_id' => ['nullable', 'exists:room,id'],
    ];

    public function mount(ClinicUser $clinicUser): void
    {
        $this->clinicUser = $clinicUser;
        $this->roomsForSelect = Room::pluck('name', 'id');
        $this->resetRoomData();
    }

    public function resetRoomData(): void
    {
        $this->room = new Room();

        $this->room_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newRoom(): void
    {
        $this->modalTitle = trans('crud.clinic_user_rooms.new_title');
        $this->resetRoomData();

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        $this->authorize('create', Room::class);

        //dd($this->room_id);
        //$clincUserRoom = $this->room_id;
        $clincUser = $this->clinicUser;

        $clincUser->room_id = $this->room_id;
        // dd($clincUser->room_id);
        // $this->clinicUser->clinics()->attach($this->clinic_id, []);

        $clincUser->save();


        $this->hideModal();
        $this->emit('refreshPage');
    }

    public function detach($room): void
    {
        $this->authorize('delete-any', Room::class);

        $this->clinicUser->rooms()->detach($room);

        $this->resetRoomData();
    }

    public function render(): View
    {
        // dd($this);
        // $room = $this->clinicUser->room;
        // dd($room);
        // $room_name = $room->name;
        // $room_id = $room->id;
        $room_name = $this->clinicUser->room->name ?? '-';
        $room_id = $this->clinicUser->room->id ?? '-';
        return view('livewire.clinic-user-rooms-detail', [
            'room_name' => $room_name,
            'room_id' => $room_id,
        ]);
    }
}
