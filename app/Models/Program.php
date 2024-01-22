<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'collage_id', 'campus_id','department_id'];

    protected $searchableFields = ['*'];

    public function collage()
    {
        return $this->belongsTo(Collage::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
