<?php

namespace App\Http\Controllers;

use App\Models\UploadedImage;
use Illuminate\Http\Request;

class UploadedImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkValidation = $request->validate([
                'image' => 'required|image',
                'title' => 'required|string',
                'description' => 'required|string',
            ]);
    
            $file = $request->file('image');
            $path = $file->store('public/images');
    
            $image = UploadedImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'path' => $path,
                'file_type' => $file->extension(),
                'size' => $file->getSize(),
            ]);
    
            return response()->json([
                'message' => 'Image uploaded successfully',
                'data' => [
                    'id' => $image->id,
                    'title' => $image->title,
                    'description' => $image->description,
                    'file_type' => $image->file_type,
                    'file_size' => $image->size,
                    'file_path' => $image->path,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UploadedImage $uploadedImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UploadedImage $uploadedImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UploadedImage $uploadedImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UploadedImage $uploadedImage)
    {
        //
    }
}
