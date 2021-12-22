<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssetBundle extends Model
{
    //

    use SoftDeletes;


    protected $fillable = [
        'asset_bundle',

    ];


    public function getAssetBundleAttribute($val){
        return ($val !==null)?asset('https://ve.adgroup.tech/developers/bundle/'.$val):"";
    }


}
