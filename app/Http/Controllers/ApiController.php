<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class ApiController extends Controller
{
    public function saveAnimation(Request $request)
    {
    	$image = explode(',', $request->image);
    	$data = base64_decode($image[1]); 
    	$nameFile = $request->name;
		//$file =Storage::put($nameFile, $data);
		Image::make($data)->resize('800','250')->save($nameFile);
    	return "exito";


    }
    public function renderAnimation(Request $request)
    {
    	
    	$output = [];
    	$proyectName = $request->name . '.mp4';
    	$velocity = round( 0.6 / $request->vel) ;
    	$mp4 = $proyectName;
    	$cmd = 'ffmpeg -framerate ' . $velocity . ' -i "image%1d.jpg" ' . $mp4;
    	$sh = fopen("render.sh", 'w');
    	fwrite($sh, $cmd);
    	fclose($sh);
    	shell_exec("render.sh");
    	
       	$path = route('downloadAnimation', $mp4);
        return $path;
    }
    public function downloadProyect($fileName)
    {
        return response()->download($fileName)->deleteFileAfterSend(true);

    }
}
