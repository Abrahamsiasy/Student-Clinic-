<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'product_id',
        'batch_number',
        'expire_date',
        'brand',
        'supplier_name',
        'campany_name',
        'number_of_units',
        'unit_type',
        'number_of_unit_per_pack',
        'unit_price',
        'price_per_unit',
        'profit_margit',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'expire_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function itemsInPharmacies()
    {
        return $this->hasMany(ItemsInPharmacy::class);
    }
}
