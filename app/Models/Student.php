<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'photo',
        'id_number',
        'rfid',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'students';

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->middle_name) . ' ' . ucfirst($this->last_name);
    }

    public function encounter()
    {
        return $this->hasMany(Encounter::class);
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function mainDiagnoses()
    {
        return $this->hasMany(MainDiagnosis::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }


    public function sfGuardUser()
    {
        return $this->belongsTo(SfGuardUser::class, 'sf_guard_user_id', 'id');
    }

    public function studentInfo()
    {
        return $this->hasOne(StudentInfo::class, 'student_id', 'id')->where('record_status', 1);
    }

    public function studentDetail()
    {
        return $this->hasOne(StudentDetail::class, 'student_id', 'id');
    }
}
