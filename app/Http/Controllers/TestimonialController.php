<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // List all testimonials
    public function index()
    {
        return response()->json(Testimonial::all());
    }

    // Store new testimonial
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $testimonial = Testimonial::create($request->only('name', 'title', 'message'));

        return response()->json($testimonial, 201);
    }

    // Show one testimonial
    public function show($id)
    {
        return response()->json(Testimonial::findOrFail($id));
    }

    // Update testimonial
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'title' => 'nullable|string|max:255',
            'message' => 'sometimes|string',
        ]);

        $testimonial->update($request->only('name', 'title', 'message'));

        return response()->json($testimonial);
    }

    // Delete testimonial
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return response()->json(null, 204);
    }
}
