<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Encounter;
use App\Models\ItemsInPharmacy;
use Livewire\WithPagination;
use App\Models\Prescription;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EncounterPrescriptionsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Encounter $encounter;
    public Prescription $prescription;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;
    public $itemsInPharmcy;
    public $items_in_pharmacies_id;
    public $location_of_medication;



    public $modalTitle = 'New Prescription';

    protected $rules = [
        'prescription.drug_name' => ['nullable', 'max:255', 'string'],
        'prescription.dose' => ['nullable', 'max:255', 'string'],
        'prescription.frequency' => ['nullable', 'max:255', 'string'],
        'prescription.duration' => ['nullable', 'max:255', 'string'],
        'prescription.other_info' => ['nullable', 'max:255', 'string'],
        'prescription.items_in_pharmacies_id' => ['nullable'],
    ];

    public function mount(Encounter $encounter)
    {
        $this->encounter = $encounter;

        $this->resetPrescriptionData();
    }

    public function resetPrescriptionData()
    {
        $this->prescription = new Prescription();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPrescription()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.encounter_prescriptions.new_title');
        $this->resetPrescriptionData();

        $this->showModal();
    }

    public function editPrescription(Prescription $prescription)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.encounter_prescriptions.edit_title');
        $this->prescription = $prescription;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
        // dd($this->encounter->Doctor?->clinicUsers?->clinic?->clinicPharmcy?->id);
        // $id = $this->encounter?->Doctor?->clinicUsers?->clinic?->clinicPharmcy?->id;
        // $items = ItemsInPharmacy::where('pharmacy_id', $id)->pluck('id', 'name');
        // $this->itemsInPharmcy = $items;

    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        // dd($this);
        $this->validate();

        if (!$this->prescription->encounter_id) {
            $this->authorize('create', Prescription::class);

            $this->prescription->encounter_id = $this->encounter->id;
            // dd($this->encounter->Doctor->clinicUsers->clinic);
            $this->prescription->clinic_id = $this->encounter->Doctor->clinicUsers->clinic->id;
        } else {
            $this->authorize('update', $this->prescription);
        }
        // dd($this);
        if ($this->prescription->drug_name == null) {
            dd($this->prescription->product_id);
            $this->prescription->location_of_medication = 0;
            // $item = ItemsInPharmacy::where('id', $this->prescription->items_in_pharmacies_id)->first();
            // $product=$item->item->product->id;
            // $product = $item->item->product;
            // $this->prescription->product_id = $item->item->product->id;
            // $this->prescription->drug_name = $product->name;
        } else {
            $this->prescription->location_of_medication = 1;
            $this->prescription->product_id = Null;
        }

        // dd($this->prescription);
        $this->prescription->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Prescription::class);

        Prescription::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPrescriptionData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->encounter->prescriptions as $prescription) {
            array_push($this->selected, $prescription->id);
        }
    }

    public function render()
    {
        $id = $this->encounter?->Doctor?->clinicUsers?->clinic?->clinicPharmcy?->id;
        $items = ItemsInPharmacy::where('pharmacy_id', $id);
        $this->itemsInPharmcy = $items->get();
        // dd($this->itemsInPharmcy->get());
        return view('livewire.encounter-prescriptions-detail', [
            'prescriptions' => $this->encounter->prescriptions()->paginate(20),
            'itemsInPharmcy' => [$this->itemsInPharmcy],
            'clinic_id' => $this->encounter?->Doctor?->clinicUsers?->clinic->id,
            'encounter_id' => $this->encounter->id,


        ]);
    }
}
