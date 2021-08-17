<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'commercial_name',
        'contact_person',
        'email',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function project(){
        return $this->hasMany(Project::class);
    }




}
