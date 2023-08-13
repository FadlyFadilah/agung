<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MahasiswaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mahasiswa_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mahasiswa = Mahasiswa::with(['user', 'prodi'])->where('user_id', auth()->user()->id)->first();
        
        $prodis = Prodi::pluck('nama_prodi', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.mahasiswas.index', compact('mahasiswa', 'prodis'));
    }

    public function store(StoreMahasiswaRequest $request)
    {
        $mahasiswa = Mahasiswa::updateOrCreate([
            'user_id'   => auth()->user()->id,
        ], [
            'nama_lengkap'     => $request->get('nama_lengkap'),
            'nim' => $request->get('nim'),
            'jenis_kelamin'   => $request->get('jenis_kelamin'),
            'prodi_id'    => $request->get("prodi_id"),
        ]);

        return redirect()->route('frontend.mahasiswas.index')->with('success', 'Berhasil Mengupdate');
    }
}
