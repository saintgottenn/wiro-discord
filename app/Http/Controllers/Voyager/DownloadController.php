<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download(Request $request)
    {   
        $file_name = $request->path;

        $file_path = public_path($file_name);
        
        if (file_exists($file_path)) {
            return response()->download($file_path);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
