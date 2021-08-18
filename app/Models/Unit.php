<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [

        'project_id',
        'developer_id',
        'unit_type',
        'floor_space',
        'status',
        'bedroom',
        'bathroom',
        'usage',
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function developer(){
        return $this->belongsTo(Developer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
