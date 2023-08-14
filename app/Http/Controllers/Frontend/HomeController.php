<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Prodi;

class HomeController
{
    public function index()
    {
        $prodis = Prodi::withCount(['mahasiswas'])->get();
        return view('frontend.home', compact('prodis'));
    }
}
