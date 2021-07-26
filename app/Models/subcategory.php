<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class subcategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $fillable = [
        'translation_lang','parent_id' , 'category_id','translation_of'	,'name',	'slug',	'photo'	,'active','created_at',	'updated_at'

];


protected $hidden = ['category_id'];

// protected static function boot(){
//     parent::boot();
//     main_categories::observe(main_category_observer::class);
// }

public function scopeActive($query){
    return $query -> where('active' ,1) ;
}

public function getActive(){
    return $this->active==1?'مفعل': 'غير مفعل';
}

public function categore()
{
 return  $this->hasMany(self::class , 'translation_of');
}

public function vendor()
{
 return  $this->hasMany('App\Models\vendor' , 'subcategory_id' , 'id');
}

// get main category .....
public function category()
{
 return  $this->belongsTo('App\Models\main_categories' , 'category_id' , 'id');
}

public function scopeparent($q){
    return $q -> where('translation_of' , 0);
}


// المنتجات 
public function producte(){
    return $this->hasMany(producte::class, 'subcategory_id' , 'id');
}


}
