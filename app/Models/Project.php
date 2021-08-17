<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;
    protected $fillabe = [
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
}
