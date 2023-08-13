<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $endDate = Carbon::now(); // Hari ini
        $startDate = Carbon::now()->subWeek(); // 1 minggu yang lalu

        $beritas = ContentPage::whereBetween('created_at', [$startDate, $endDate])->get();
        
        return view('welcome', compact('beritas'));
    }

    public function show(ContentPage $contentPage)
    {
        return view('details', compact('contentPage'));
    }

    public function lomba()
    {
        $beritas = ContentPage::get();
        
        return view('lomba', compact('beritas'));
    }
}
