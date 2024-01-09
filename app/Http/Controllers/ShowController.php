<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\Times\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ShowController extends Controller
{
    public function show($code, Request $request)
    {
        $file = File::where('code', $code)->firstOrFail();
        
        return view('pages.show.index', compact('file'));
    }

    public function register_new()
    {
        
        return view('auth.register');
    }

    public function download($code)
    {
        $file = File::where('code', $code)->firstOrFail();
        if($file->extension=='jpg' || $file->extension=='jpeg' || $file->extension=='png' || $file->extension=='gif'){
            $name = 'https://sin1.contabostorage.com/833352dc474e43209813e72560512fa1:filehost/'.$file->path;
            $fp = fopen($name, 'rb');

            header("Content-Type: image/png");
            header("Content-Type: image/jpeg");
            //header("Content-Length: " . filesize($name));

            fpassthru($fp);
        }
        return Storage::disk($file->storageServer->name)
            ->download($file->path, config('app.name') . '-' . $file->client_original_name);

        
    }
}
