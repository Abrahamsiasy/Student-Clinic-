<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTestRequest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'sample_collected_at',
        'sample_analyzed_at',
        'status',
        'notification',
        'note',
        'result',
        'comment',
        'analyser_result',
        'approved_at',
        'price',
        'sample_id',
        'ordered_on',
        'lab_test_request_group_id',
        'sample_collected_by_id',
        'sample_analyzed_by_id',
        'lab_catagory_id',
        'approved_by_id',
        'encounter_id',
        'lab_test_id',
        'upload',
        'closed_at'
    
    ];

    protected $searchableFields = ['*'];

    protected $table = 'lab_test_requests';

    protected $casts = [
        'sample_collected_at' => 'datetime',
        'sample_analyzed_at' => 'datetime',
        'approved_at' => 'datetime',
        'ordered_on' => 'datetime',
        'closed_at'=> 'datetime',
       
    ];

    public function labTestRequestGroup()
    {
        return $this->belongsTo(LabTestRequestGroup::class);
    }


    public function encounter()
    {
        return $this->belongsTo(Encounter::class);
    }

    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }


    public function sampleCcollectedBy()
    {
        return $this->belongsTo(ClinicUser::class, 'sample_collected_by_id');
    }

    public function sampleAnalyzedBy()
    {
        return $this->belongsTo(ClinicUser::class, 'sample_analyzed_by_id');
    }

    public function labCatagory()
    {
        return $this->belongsTo(LabCatagory::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(ClinicUser::class, 'approved_by_id');
    }



   
}
