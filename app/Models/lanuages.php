<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lanuages extends Model
{
    use HasFactory;
    
    protected $fillable = [
        	'abbr','local',	'name',	'direction','active' ,'created_at',	'updated_at'


    ];

     public function getActive(){
         return $this->active==1?'مفعل': 'غير مفعل';
     }

     public function active(){
        return $this->active->where(1);
    }
     
}
