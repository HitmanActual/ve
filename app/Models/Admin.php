<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use SoftDeletes,Notifiable,HasApiTokens;

    //
    protected $guarded=['id'];
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAuthPassword()
    {
        return $this->password;
    }




}
