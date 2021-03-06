<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    //

    use SoftDeletes;
    protected $table = 'cities';


    protected $fillable = [
        'name',
        'state_id',
    ];


    public function state()
    {
        return $this->belongsTo(State::class);

    }


    public function project()
    {
        return $this->hasMany(Project::class);

    }


    public function developer()
    {
        return $this->hasMany(Developer::class);

    }

}
