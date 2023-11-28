<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabCatagory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['lab_name', 'lab_desc'];

    protected $searchableFields = ['*'];

    protected $table = 'lab_catagories';

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function labTestRequests()
    {
        return $this->hasMany(LabTestRequest::class);
    }

   
}
