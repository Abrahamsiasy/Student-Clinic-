<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'drug_name',
        'dose',
        'frequency',
        'duration',
        'other_info',
        'main_diagnosis_id',
        'encounter_id',
        'items_in_pharmacies_id',
        'product_id',
        'location_of_medication',
        'clinic_id'


    ];

    protected $searchableFields = ['*'];

    public function mainDiagnosis()
    {
        return $this->belongsTo(MainDiagnosis::class);
    }
    public function encounter()
    {
        return $this->belongsTo(Encounter::class, 'encounter_id');
    }

    public function itemInPharmacy()
    {
        return $this->belongsTo(ItemsInPharmacy::class, 'items_in_pharmacies_id');
    }
}
