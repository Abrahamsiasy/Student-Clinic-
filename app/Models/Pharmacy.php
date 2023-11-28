<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pharmacy extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'admin_id',
        // 'campus_id',
        'status',
        'description',
        'clinic_id',
        'store_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'status' => 'boolean',
    ];

    // public function campus()
    // {
    //     return $this->belongsTo(Campus::class);
    // }

    public function itemsInPharmacies()
    {
        return $this->hasMany(ItemsInPharmacy::class);
    }

    public function pharmacyUsers()
    {
        return $this->hasMany(PharmacyUser::class);
    }

    public function itemRequests()
    {
        return $this->hasMany(ItemRequest::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function storesToPharmacies()
    {
        return $this->hasMany(StoresToPharmacy::class);
    }
}
