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
}
