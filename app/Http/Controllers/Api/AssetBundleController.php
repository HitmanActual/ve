<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetBundle;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetBundleController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bundles = AssetBundle::all();
        return $this->successResponse($bundles, Response::HTTP_OK);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $bundle = new AssetBundle();
        $image = $request->asset_bundle;

        $filename = $image->getClientOriginalName();
        $bundle->asset_bundle = $filename;

       // $image->storeAs('/public/bundle', $filename);
        $image->storeAs('/public/bundle', $filename);
        $bundle->save();
        return $this->successResponse($bundle, Response::HTTP_CREATED);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssetBundle  $assetBundle
     * @return \Illuminate\Http\Response
     */
    public function show($assetBundle)
    {
        //
        $bundle= AssetBundle::findOrFail($assetBundle);

        return $bundle;

    }



    public function getAssetBundle(Request $request)
    {
        //


        $object = $request->query('object');



        $bundle = AssetBundle::select('asset_bundle')->where('asset_bundle','LIKE','%'.$object.'%')->get();
        return $bundle;
//
       return $bundle;


    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssetBundle  $assetBundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetBundle $assetBundle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssetBundle  $assetBundle
     * @return \Illuminate\Http\Response
     */
    public function destroy( $assetBundle)
    {
        //
    }
}
