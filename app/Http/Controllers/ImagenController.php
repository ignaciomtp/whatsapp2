<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['upload' => 'required|image|max:2048']);

        $path = $request->file('upload')->store('imagenes', 'public');

        return response()->json([
            'url' => Storage::url($path)
        ]);
    }
}
