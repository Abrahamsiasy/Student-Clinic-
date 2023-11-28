<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicUser extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'encounter_id'];

    protected $searchableFields = ['*'];

    protected $table = 'clinic_users';





    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function encounterDoctor()
    {
        return $this->hasMany(Encounter::class, 'doctor_id');
    }

    public function encounterRegisteredBy()
    {
        return $this->hasMany(Encounter::class, 'registered_by');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function labTestRequestGroups()
    {
        return $this->hasMany(LabTestRequestGroup::class);
    }

    public function labTestRequests()
    {
        return $this->hasMany(LabTestRequest::class, 'sample_collected_by_id');
    }

    public function labTestRequests2()
    {
        return $this->hasMany(LabTestRequest::class, 'sample_analyzed_by_id');
    }

    public function labTestRequests3()
    {
        return $this->hasMany(LabTestRequest::class, 'approved_by_id');
    }

    public function mainDiagnoses()
    {
        return $this->hasMany(MainDiagnosis::class);
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }


    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
