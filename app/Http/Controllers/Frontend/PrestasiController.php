<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPrestasiRequest;
use App\Http\Requests\StorePrestasiRequest;
use App\Http\Requests\UpdatePrestasiRequest;
use App\Models\Mahasiswa;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PrestasiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('prestasi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->first();
        if ($mahasiswa === NULL) {
            return back()->with('error', 'Isi Dahulu Data Mahasiswa');
        }
        $prestasis = Prestasi::where('mahasiswa_id', $mahasiswa->id)->get();

        return view('frontend.prestasis.index', compact('prestasis'));
    }

    public function create()
    {
        abort_if(Gate::denies('prestasi_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mahasiswas = Mahasiswa::pluck('nama_lengkap', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.prestasis.create', compact('mahasiswas'));
    }

    public function store(StorePrestasiRequest $request)
    {
        $attr = $request->all();
        $mahasiswa = Mahasiswa::where('user_id', auth()->user()->id)->first();
        $attr['mahasiswa_id'] = $mahasiswa->id;
        $attr['status'] = "Pending";

        $prestasi = Prestasi::create($attr);

        if ($request->input('sertifikat', false)) {
            $prestasi->addMedia(storage_path('tmp/uploads/' . basename($request->input('sertifikat'))))->toMediaCollection('sertifikat');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $prestasi->id]);
        }

        return redirect()->route('frontend.prestasis.index');
    }

    public function edit(Prestasi $prestasi)
    {
        abort_if(Gate::denies('prestasi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mahasiswas = Mahasiswa::pluck('nama_lengkap', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prestasi->load('mahasiswa');

        return view('frontend.prestasis.edit', compact('mahasiswas', 'prestasi'));
    }

    public function update(UpdatePrestasiRequest $request, Prestasi $prestasi)
    {
        $attr = $request->all();
        $mahasiswa = Mahasiswa::where('user_id', auth()->user()->id)->first();
        $attr['mahasiswa_id'] = $mahasiswa->id;
        
        $prestasi->update($attr);

        if ($request->input('sertifikat', false)) {
            if (! $prestasi->sertifikat || $request->input('sertifikat') !== $prestasi->sertifikat->file_name) {
                if ($prestasi->sertifikat) {
                    $prestasi->sertifikat->delete();
                }
                $prestasi->addMedia(storage_path('tmp/uploads/' . basename($request->input('sertifikat'))))->toMediaCollection('sertifikat');
            }
        } elseif ($prestasi->sertifikat) {
            $prestasi->sertifikat->delete();
        }

        return redirect()->route('frontend.prestasis.index');
    }

    public function show(Prestasi $prestasi)
    {
        abort_if(Gate::denies('prestasi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prestasi->load('mahasiswa');

        return view('frontend.prestasis.show', compact('prestasi'));
    }

    public function destroy(Prestasi $prestasi)
    {
        abort_if(Gate::denies('prestasi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prestasi->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrestasiRequest $request)
    {
        $prestasis = Prestasi::find(request('ids'));

        foreach ($prestasis as $prestasi) {
            $prestasi->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('prestasi_create') && Gate::denies('prestasi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Prestasi();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}