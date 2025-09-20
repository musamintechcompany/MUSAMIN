<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

class IdeaController extends Controller
{
    public function index()
    {
        return view('ideas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string|min:20',
            'benefits' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|min:7',
            'country_code' => 'required|string',
            'media.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,mp4,mov,avi'
        ]);

        $mediaFiles = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('ideas/media', 'public');
                $mediaFiles[] = $path;
            }
        }

        $idea = Idea::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'additional_info' => $request->additional_info,
            'media_files' => $mediaFiles,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'country_code' => $request->country_code,
            'hashid' => Hashids::encode(time() . rand(1000, 9999))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Idea submitted successfully!',
            'idea_id' => $idea->id
        ]);
    }
}