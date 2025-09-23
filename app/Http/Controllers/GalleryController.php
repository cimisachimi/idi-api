<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// We are removing the Intervention/Image dependency to fix the server error.
// use Intervention\Image\Facades\Image; 

class GalleryController extends Controller
{
    // List all galleries
    public function index()
    {
        return response()->json(Gallery::paginate(15));
    }

    // Store new gallery item
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            // Allow more common image types and increase max size to 5MB
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        // Use Laravel's built-in file storage system
        if ($request->hasFile('image')) {
            // The 'store' method handles file naming and placement automatically.
            // It will store the file in `storage/app/public/galleries`.
            $path = $request->file('image')->store('galleries', 'public');

            $gallery = Gallery::create([
                'title' => $request->title,
                'image_path' => $path, // Save the path returned by the store method
            ]);

            return response()->json($gallery, 201);
        }

        return response()->json(['message' => 'Image not provided.'], 400);
    }

    // Show one item
    public function show($id)
    {
        return response()->json(Gallery::findOrFail($id));
    }

    // Update (including image if provided)
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($gallery->image_path);

            // Store the new image
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image_path = $path;
        }

        if ($request->filled('title')) {
            $gallery->title = $request->title;
        }

        $gallery->save();

        return response()->json($gallery);
    }

    // Delete
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete the image file from storage
        Storage::disk('public')->delete($gallery->image_path);

        // Delete the record from the database
        $gallery->delete();

        return response()->json(null, 204);
    }
}