<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $fillable = ['name', 'username', 'email', 'password'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->name);
    }
    public function clinicUsers()
    {
        return $this->hasOne(ClinicUser::class);
    }
    public function storeUser()
    {
        return $this->hasOne(StoreUser::class);
    }

    public function pharmacyUsers()
    {
        return $this->hasOne(PharmacyUser::class);
    }


    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_clinic_user');
    }


    public function encounters()
    {
        return $this->hasMany(Encounter::class,'doctor_id');
    }






}
