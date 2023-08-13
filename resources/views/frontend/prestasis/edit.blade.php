@extends('layouts.frontend')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.prestasi.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("frontend.prestasis.update", [$prestasi->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="nama_lomba">{{ trans('cruds.prestasi.fields.nama_lomba') }}</label>
                <input class="form-control {{ $errors->has('nama_lomba') ? 'is-invalid' : '' }}" type="text" name="nama_lomba" id="nama_lomba" value="{{ old('nama_lomba', $prestasi->nama_lomba) }}" required>
                @if($errors->has('nama_lomba'))
                    <span class="text-danger">{{ $errors->first('nama_lomba') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.nama_lomba_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.prestasi.fields.bidang_lomba') }}</label>
                <select class="form-control {{ $errors->has('bidang_lomba') ? 'is-invalid' : '' }}" name="bidang_lomba" id="bidang_lomba" required>
                    <option value disabled {{ old('bidang_lomba', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Prestasi::BIDANG_LOMBA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('bidang_lomba', $prestasi->bidang_lomba) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('bidang_lomba'))
                    <span class="text-danger">{{ $errors->first('bidang_lomba') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.bidang_lomba_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tanggal_pelaksanaan">{{ trans('cruds.prestasi.fields.tanggal_pelaksanaan') }}</label>
                <input class="form-control date {{ $errors->has('tanggal_pelaksanaan') ? 'is-invalid' : '' }}" type="text" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $prestasi->tanggal_pelaksanaan) }}" required>
                @if($errors->has('tanggal_pelaksanaan'))
                    <span class="text-danger">{{ $errors->first('tanggal_pelaksanaan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.tanggal_pelaksanaan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tempat_pelaksanaan">{{ trans('cruds.prestasi.fields.tempat_pelaksanaan') }}</label>
                <input class="form-control {{ $errors->has('tempat_pelaksanaan') ? 'is-invalid' : '' }}" type="text" name="tempat_pelaksanaan" id="tempat_pelaksanaan" value="{{ old('tempat_pelaksanaan', $prestasi->tempat_pelaksanaan) }}" required>
                @if($errors->has('tempat_pelaksanaan'))
                    <span class="text-danger">{{ $errors->first('tempat_pelaksanaan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.tempat_pelaksanaan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="prestasi_juara">{{ trans('cruds.prestasi.fields.prestasi_juara') }}</label>
                <input class="form-control {{ $errors->has('prestasi_juara') ? 'is-invalid' : '' }}" type="text" name="prestasi_juara" id="prestasi_juara" value="{{ old('prestasi_juara', $prestasi->prestasi_juara) }}" required>
                @if($errors->has('prestasi_juara'))
                    <span class="text-danger">{{ $errors->first('prestasi_juara') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.prestasi_juara_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tingkat">{{ trans('cruds.prestasi.fields.tingkat') }}</label>
                <input class="form-control {{ $errors->has('tingkat') ? 'is-invalid' : '' }}" type="text" name="tingkat" id="tingkat" value="{{ old('tingkat', $prestasi->tingkat) }}" required>
                @if($errors->has('tingkat'))
                    <span class="text-danger">{{ $errors->first('tingkat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.tingkat_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sertifikat">{{ trans('cruds.prestasi.fields.sertifikat') }}</label>
                <div class="needsclick dropzone {{ $errors->has('sertifikat') ? 'is-invalid' : '' }}" id="sertifikat-dropzone">
                </div>
                @if($errors->has('sertifikat'))
                    <span class="text-danger">{{ $errors->first('sertifikat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.prestasi.fields.sertifikat_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.sertifikatDropzone = {
    url: '{{ route('frontend.prestasis.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="sertifikat"]').remove()
      $('form').append('<input type="hidden" name="sertifikat" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="sertifikat"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($prestasi) && $prestasi->sertifikat)
      var file = {!! json_encode($prestasi->sertifikat) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="sertifikat" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection