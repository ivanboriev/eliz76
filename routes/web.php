<?php
use Illuminate\Http\Request;

Route::get('download',function (Request $request){
    $path = $request->get('path');
    $name = $request->get('name');
    return response()->download(public_path($path), $name, array('Content-Type: application/zip'));
});
Route::get('templates','SinglePageController@index');

Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
