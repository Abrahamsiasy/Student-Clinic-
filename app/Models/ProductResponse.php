<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductResponse extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['tin_number','product_request_id','approved_by'];

    protected $searchableFields = ['tin_number'];

    protected $table = 'product_responses';



    public function productRequest()
    {
        return $this->belongsTo(ProductRequest::class);
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class,'approved_by');
    }

}
