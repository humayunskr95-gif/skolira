<?php
namespace App\Http\Controllers\SchoolSite;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class SitePlanController extends Controller
{
    public function pricing()
    {
        $plans = Plan::all();
        return view('school_site.pricing', compact('plans'));
    }
}