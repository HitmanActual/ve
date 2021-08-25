<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Developer extends Authenticatable
{
    use SoftDeletes,Notifiable,HasApiTokens;

    //
    protected $guarded=['id'];

    protected $fillable = [
        'commercial_name',
        'contact_person',
        'email',
        'phone',
        'password',
        'image_path',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function project(){
        return $this->hasMany(Project::class);
    }

    public function getAuthPassword()
    {
        return $this->password;
    }


    public function getImagePathAttribute($val){
        return ($val !==null)?asset('storage/developers/'.$val):"";
    }




}
