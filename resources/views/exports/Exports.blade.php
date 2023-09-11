<table>
    <thead>
        <tr>
            <th style="font-weight: bold; text-align: center">NO</th>
            <th style="font-weight: bold; text-align: center">Nama</th>
            <th style="font-weight: bold; text-align: center">Nama Lomba</th>
            <th style="font-weight: bold; text-align: center">Bidang Lomba</th>
            <th style="font-weight: bold; text-align: center">Tanggal Pelaksanaan</th>
            <th style="font-weight: bold; text-align: center">Tempat Pelaksanaan</th>
            <th style="font-weight: bold; text-align: center">Prestasi Juara</th>
            <th style="font-weight: bold; text-align: center">Tingkat</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($prestasi as $key => $prestasi)
            <tr data-entry-id="{{ $prestasi->id }}">
                <td>
                    {{ $no++ }}
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
            </tr>
        @endforeach
    </tbody>
</table>
