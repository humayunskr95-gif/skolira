<?php
namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class SchoolGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('school_id', auth()->user()->school_id)
            ->latest()->paginate(12);

        return view('school_admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('school_admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'school_id' => auth()->user()->school_id,
            'image' => $path,
            'title' => $request->title
        ]);

        return back()->with('success', 'Image uploaded');
    }

    public function delete($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return back()->with('success', 'Deleted');
    }
}