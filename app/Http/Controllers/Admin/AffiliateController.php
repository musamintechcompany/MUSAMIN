<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        $affiliates = Affiliate::with('user')->latest()->paginate(20);
        return view('management.portal.admin.affiliates.index', compact('affiliates'));
    }

    public function show(Affiliate $affiliate)
    {
        $affiliate->load('user');
        return view('management.portal.admin.affiliates.show', compact('affiliate'));
    }

    public function destroy(Affiliate $affiliate)
    {
        $affiliate->delete();
        return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate deleted successfully');
    }
}