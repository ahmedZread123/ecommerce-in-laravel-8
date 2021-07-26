<?php

namespace App\Models;

use App\Observers\main_category_observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class main_categories extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'translation_lang',	'translation_of'	,'name',	'slug',	'photo'	,'active','created_at',	'updated_at'
];

protected static function boot(){
    parent::boot();
    main_categories::observe(main_category_observer::class);
}

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
 return  $this->hasMany('App\Models\vendor' , 'category_id' , 'id');
}

public  function supcategory()
{
 return  $this->hasMany('App\Models\subcategory' , 'category_id' , 'id');
}

public function sup(){
    return $this->hasMany('App\Models\subcategory' , 'category_id' , 'id')->where('translation_of' , 0)->where('active',1);
}
public function scopeparent($q){
    return $q -> where('translation_of' , 0);
}

   
}
