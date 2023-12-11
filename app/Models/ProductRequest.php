<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRequest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['amount', 'product_id', 'store_id', 'pharmacy_id','status','approval_amount','approved_at','rejected_at','to_be_approved','reason_of_rejection'];

    protected $searchableFields = ['*'];

    protected $table = 'product_requests';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
