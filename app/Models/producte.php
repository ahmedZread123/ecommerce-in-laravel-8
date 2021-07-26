<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producte extends Model
{
    use HasFactory;
    protected $table = 'productes';
    
    protected $fillable = [
        'name',
    	'contact',
    	'price',
    	'photo'	,
       'vendor_id'	, 
        'subcategory_id',
    	'active',	
       'namber',
    ];
    
   // التاجر 
    public function vendor(){
        return $this->belongsTo(vendor::class, 'vendor_id' , 'id');
    }
  // الاقسام 
    public function subcategory(){
        return $this->belongsTo(subcategory::class , 'subcategory_id' , 'id');

    }


    // الحالة 
    public function scopeActive($query){
        return $query -> where('active' ,1) ;
    }
    
    public function getActive(){
        return $this->active==1?'مفعل': 'غير مفعل';
    }
    
    //العلاقة مع الطلبات 
    public function order(){
        return $this->hasMany(order::class ,  'product_id' , 'id');
    }

    // الاحجام 

    public function size(){
        return $this->hasMany(size::class);
    }
    
}
