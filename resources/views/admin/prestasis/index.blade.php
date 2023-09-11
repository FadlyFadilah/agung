@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        @can('prestasi_create')
            <div class="col-lg-6">
                <a class="btn btn-success" href="{{ route('admin.prestasis.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.prestasi.title_singular') }}
                </a>
            </div>
        @endcan
        <div class="col-lg-6">
            <form action="{{ route('admin.export.full') }}" method="post" required>
                @csrf
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Download Exel</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.prestasi.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Prestasi">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.mahasiswa') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.nama_lomba') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.bidang_lomba') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.tanggal_pelaksanaan') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.tempat_pelaksanaan') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.prestasi_juara') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.tingkat') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.sertifikat') }}
                            </th>
                            <th>
                                {{ trans('cruds.prestasi.fields.status') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestasis as $key => $prestasi)
                            <tr data-entry-id="{{ $prestasi->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $prestasi->id ?? '' }}
                                </td>
                                <td>
                                    {{ $prestasi->mahasiswa->nama_lengkap ?? '' }}
                                </td>
                                <td>
                                    {{ $prestasi->nama_lomba ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\Prestasi::BIDANG_LOMBA_SELECT[$prestasi->bidang_lomba] ?? '' }}
                                </td>
                                <td>
                                    {{ $prestasi->tanggal_pelaksanaan ?? '' }}
                                </td>
                                <td>
                                    {{ $prestasi->tempat_pelaksanaan ?? '' }}
                                </td>
                                <td>
                                    {{ $prestasi->prestasi_juara ?? '' }}
                                </td>
                                <td>
                                    {{ $prestasi->tingkat ?? '' }}
                                </td>
                                <td>
                                    @if ($prestasi->sertifikat)
                                        <a href="{{ $prestasi->sertifikat->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ App\Models\Prestasi::STATUS_SELECT[$prestasi->status] ?? '' }}
                                </td>
                                <td>
                                    @can('prestasi_edit')
                                        <form id="verif-form-{{ $prestasi->id }}"
                                            action="{{ route('admin.prestasis.verif', $prestasi->id) }}" method="POST"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="PATCH">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="status" value="Terverifikasi">
                                            <button type="button" class="btn btn-xs btn-success"
                                                onclick="prestasiVerif({{ $prestasi->id }})">
                                                Verif
                                            </button>
                                        </form>

                                        <form id="tolak-form-{{ $prestasi->id }}"
                                            action="{{ route('admin.prestasis.verif', $prestasi->id) }}" method="POST"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="PATCH">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="button" class="btn btn-xs btn-warning"
                                                onclick="prestasiTolak({{ $prestasi->id }})">
                                                Tolak
                                            </button>
                                        </form>
                                    @endcan

                                    @can('prestasi_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.prestasis.show', $prestasi->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('prestasi_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.prestasis.edit', $prestasi->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('prestasi_delete')
                                        <form id="delete-form-{{ $prestasi->id }}"
                                            action="{{ route('admin.prestasis.destroy', $prestasi->id) }}" method="POST"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="button" class="btn btn-xs btn-danger"
                                                onclick="deleteprestasi({{ $prestasi->id }})">
                                                {{ trans('global.delete') }}
                                            </button>
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        function deleteprestasi(prestasiId) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "data tidak akan bisa di kembalikan!",
                icon: 'warning',
                confirmButtonText: 'Iya, hapus!',
                showDenyButton: true,
                denyButtonText: `Tidak, batal!`,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // jika pengguna menekan tombol "Yes, delete it!", submit form
                    document.getElementById('delete-form-' + prestasiId).submit();
                    Swal.fire('Tersimpan!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Perubahan tidak di simpan', '', 'info')
                }
            });
        }
    </script>
    <script>
        function prestasiVerif(prestasiId) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Verifikasi prestasi ini!",
                icon: 'warning',
                confirmButtonText: 'Iya, Verifikasi!',
                showDenyButton: true,
                denyButtonText: `Tidak, batal!`,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // jika pengguna menekan tombol "Yes, delete it!", submit form
                    document.getElementById('verif-form-' + prestasiId).submit();
                    Swal.fire('Tersimpan!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Perubahan tidak di simpan', '', 'info')
                }
            });
        }
    </script>
    <script>
        function prestasiTolak(prestasiId) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Tolak prestasi ini!",
                icon: 'warning',
                confirmButtonText: 'Iya, Tolak!',
                showDenyButton: true,
                denyButtonText: `Tidak, batal!`,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // jika pengguna menekan tombol "Yes, delete it!", submit form
                    document.getElementById('tolak-form-' + prestasiId).submit();
                    Swal.fire('Tersimpan!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Perubahan tidak di simpan', '', 'info')
                }
            });
        }
    </script>
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('prestasi_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.prestasis.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Prestasi:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
