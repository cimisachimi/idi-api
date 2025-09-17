<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    // List all galleries
    public function index()
    {
        return response()->json(Gallery::all());
    }

    // Store new gallery item (with WebP conversion)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('image');
        $filename = time() . '.webp';

        // Convert to WebP and save to storage/app/public/galleries
        $image = Image::make($file)->encode('webp', 80);
        $path = 'galleries/' . $filename;
        $image->save(storage_path('app/public/' . $path));

        $gallery = Gallery::create([
            'title' => $request->title,
            'image_path' => $path,
        ]);

        return response()->json($gallery, 201);
    }

    // Show one item
    public function show($id)
    {
        return response()->json(Gallery::findOrFail($id));
    }

    // Update (including image if provided, converts to WebP too)
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.webp';

            $image = Image::make($file)->encode('webp', 80);
            $path = 'galleries/' . $filename;
            $image->save(storage_path('app/public/' . $path));

            $gallery->image_path = $path;
        }

        if ($request->title) {
            $gallery->title = $request->title;
        }

        $gallery->save();

        return response()->json($gallery);
    }

    // Delete
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return response()->json(null, 204);
    }
}
