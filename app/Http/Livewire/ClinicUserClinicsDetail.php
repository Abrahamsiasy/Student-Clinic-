<?php

namespace App\Http\Livewire;

use App\Models\Clinic;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\ClinicUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClinicUserClinicsDetail extends Component
{
    use AuthorizesRequests;

    public ClinicUser $clinicUser;
    public Clinic $clinic;
    public $clinicsForSelect = [];
    public $clinic_id;


    public $showingModal = false;
    public $modalTitle = 'New Clinic';

    protected $rules = [
        'clinic_id' => ['nullable', 'exists:clinic,id'],
    ];

    public function mount(ClinicUser $clinicUser): void
    {
        $this->clinicUser = $clinicUser;
        $this->clinicsForSelect = Clinic::pluck('name', 'id');
        $this->resetClinicData();
    }

    public function resetClinicData(): void
    {
        $this->clinic = new Clinic();

        $this->clinic_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newClinic(): void
    {
        $this->modalTitle = trans('crud.clinic_user_clinics.new_title');
        $this->resetClinicData();

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

        dd($this);
        // dd($this->clinicUser->clinic_id);
        // $this->validate();

        $this->authorize('create', Clinic::class);

        $clincUser = $this->clinicUser;
        $clincUser->clinic_id = $this->clinic_id;
        dd($clincUser);
        // $this->clinicUser->clinics()->attach($this->clinic_id, []);

        $clincUser->save();
        $this->hideModal();
    }

    public function detach($clinic): void
    {
        $this->authorize('delete-any', Clinic::class);

        $this->clinicUser->clinics()->detach($clinic);

        $this->resetClinicData();
    }

    public function render(): View
    {
        $clinic = $this->clinicUser->clinic ?? '-';
        $clinic_name = $clinic->name ?? '-';
        $clinic_id = $clinic->id ?? '-';

        return view('livewire.clinic-user-clinics-detail', [
            'clinic_name' => $clinic_name,
            'clinic_id' => $clinic_id,
        ]);
    }
}
