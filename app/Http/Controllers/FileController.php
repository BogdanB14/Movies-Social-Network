<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        // Validacija fajla
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4|max:10240', // Do 10MB
        ]);

        // Cuvanje fajla
        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'message' => 'Uspesan upload',
            'file_path' => $path
        ], 200);
    }
}
