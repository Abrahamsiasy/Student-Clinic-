<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'test_name',
        'test_desc',
        'lab_catagory_id',
        'status',
        'is_available',
        'price',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'lab_tests';

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function labCatagory()
    {
        return $this->belongsTo(LabCatagory::class);
    }

    public function labTestRequests()
    {
        return $this->hasMany(LabTestRequest::class);
    }

   
}
