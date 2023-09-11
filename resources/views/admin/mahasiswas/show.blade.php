@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mahasiswa.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mahasiswas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.mahasiswa.fields.id') }}
                        </th>
                        <td>
                            {{ $mahasiswa->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mahasiswa.fields.nama_lengkap') }}
                        </th>
                        <td>
                            {{ $mahasiswa->nama_lengkap }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mahasiswa.fields.nim') }}
                        </th>
                        <td>
                            {{ $mahasiswa->nim }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mahasiswa.fields.jenis_kelamin') }}
                        </th>
                        <td>
                            {{ App\Models\Mahasiswa::JENIS_KELAMIN_RADIO[$mahasiswa->jenis_kelamin] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mahasiswa.fields.prodi') }}
                        </th>
                        <td>
                            {{ $mahasiswa->prodi->nama_prodi ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mahasiswas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>


@endsection