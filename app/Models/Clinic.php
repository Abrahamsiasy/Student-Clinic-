<?php

namespace App\Models;

use App\Models\Pharmacy;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'code_clinic',
        'description',
        'lat',
        'long',
        'campus_id',
        'collage_id',
        'status',
        'is_active',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'clinic';

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function collage()
    {
        return $this->belongsTo(Collage::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }

    public function allClinicServices()
    {
        return $this->belongsToMany(ClinicServices::class);
    }

    public function clinicUsers()
    {
        return $this->belongsToMany(ClinicUser::class);
    }

    public function clinicPharmcy()
    {
        return $this->hasOne(Pharmacy::class);
    }
}
