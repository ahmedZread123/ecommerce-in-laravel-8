<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
    	'product_id',
        'name',
        'price',
    ];

    // العلاقة مع المنتج 
    public function producte(){
        return $this->hasMany(producte::class );
    }

}
