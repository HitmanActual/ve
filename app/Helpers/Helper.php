<?php
/**
 * Created by PhpStorm.
 * User: reaper
 * Date: 1/9/2021
 * Time: 2:54 PM
 */


//--handle images-----------------------
function uploadImage($folder, $image)
{

    $image->store('/', $folder);
    $filename = $image->hashName();
    // $path = 'images/' . $folder . '/' . $filename;
    return $folder.'/'.$filename;
}