<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::with('user')->latest()->paginate(15);
        return view('management.portal.admin.ideas.index', compact('ideas'));
    }

    public function show(Idea $idea)
    {
        $idea->load('user');
        return view('management.portal.admin.ideas.view', compact('idea'));
    }

    public function destroy(Idea $idea)
    {
        $idea->delete();
        return redirect()->route('admin.ideas.index')->with('success', 'Idea deleted successfully!');
    }
}