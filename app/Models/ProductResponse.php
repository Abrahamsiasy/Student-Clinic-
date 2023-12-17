<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductResponse extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['tin_number','product_request_id'];

    protected $searchableFields = ['tin_number','product_request_id'];

    protected $table = 'product_responses';
}
