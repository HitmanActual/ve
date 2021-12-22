<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [
        'project_id',
        'image_path',
        'image_type',
    ];


    public function project(){
        return $this->belongsTo(Project::class);
    }


    public function getImagePathAttribute($val){
        return ($val !==null)?asset('developers/'.$val):"";
    }




}
