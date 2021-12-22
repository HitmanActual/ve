<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'title',
        'city_id',
        'developer_id',
        'tod',
        'description',


    ];

    public function developer(){
        return $this->belongsTo(Developer::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function unit(){
        return $this->hasMany(Unit::class);
    }


    public function image(){
        return $this->hasMany(Image::class);
    }


    public function getImagePathAttribute($val){
        return ($val !==null)?asset('developers/'.$val):"";
    }
}
