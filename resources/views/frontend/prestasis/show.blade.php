@extends('layouts.frontend')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.prestasi.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('frontend.prestasis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.id') }}
                        </th>
                        <td>
                            {{ $prestasi->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.mahasiswa') }}
                        </th>
                        <td>
                            {{ $prestasi->mahasiswa->nama_lengkap ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.nama_lomba') }}
                        </th>
                        <td>
                            {{ $prestasi->nama_lomba }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.bidang_lomba') }}
                        </th>
                        <td>
                            {{ App\Models\Prestasi::BIDANG_LOMBA_SELECT[$prestasi->bidang_lomba] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.tanggal_pelaksanaan') }}
                        </th>
                        <td>
                            {{ $prestasi->tanggal_pelaksanaan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.tempat_pelaksanaan') }}
                        </th>
                        <td>
                            {{ $prestasi->tempat_pelaksanaan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.prestasi_juara') }}
                        </th>
                        <td>
                            {{ $prestasi->prestasi_juara }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.tingkat') }}
                        </th>
                        <td>
                            {{ $prestasi->tingkat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.sertifikat') }}
                        </th>
                        <td>
                            @if($prestasi->sertifikat)
                                <a href="{{ $prestasi->sertifikat->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.prestasi.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Prestasi::STATUS_SELECT[$prestasi->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('frontend.prestasis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection