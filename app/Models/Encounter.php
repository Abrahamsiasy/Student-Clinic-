<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Encounter extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'check_in_time',
        'status',
        'closed_at',
        'priority',
        'clinic_id',
        'student_id',
        'doctor_id',
        'registered_by',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'check_in_time' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function RegisteredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function Doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function labTestRequests()
    {
        return $this->hasMany(LabTestRequest::class);
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

    public function mainDiagnoses()
    {
        return $this->hasMany(MainDiagnosis::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
