<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Prodi;
use App\Models\Program;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $prodis = Prodi::withCount(['mahasiswas'])->get();
        return view('home', compact('prodis'));
    }

    public function detail($prodi)
    {
        $prodii = Prodi::where('nama_prodi', $prodi)->first();
        $prodi_id = $prodii->id;
        $mahasiswas = Mahasiswa::with('prodi', 'prestasis')
            ->where('prodi_id', $prodi_id)
            ->get();
        return view('show', compact('mahasiswas', 'prodi'));
    }
}
