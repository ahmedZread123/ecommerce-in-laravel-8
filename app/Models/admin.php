<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'admins' ;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo' ,
        'created_at',
        'updated_at'

    ];

    protected $hidden = [
        'name',
        'email',
        'password',
    ];
}
