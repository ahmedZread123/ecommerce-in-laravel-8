<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class vendor extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'vendors';

    protected $fillable = [
       'id',
        'name',
       'mobile',
      'email'	,
       'category_id',
      'address',
       	'active',
       	'logo',
       	'created_at',
       	'updated_at',
         'password',
          'subcategory_id'

    ];
 protected $hidden =['category_id' , 'password'];

 public function scopeActive($query){
  return $query->where('active',1);
 }
 public function getActive(){
    return $this->active==1?'مفعل': 'غير مفعل';
 }

 public function category()
{
 return  $this->belongsTo('App\Models\main_categories' , 'category_id' , 'id');
}

public function subcategory(){
   return $this->hasMany(subcategory::class  , 'subcategory_id' , 'id');
}

// المنتجات 
public function producte(){
   return $this->hasMany(producte::class , 'vendor_id' , 'id');
}

}
