<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Prodi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class TiExport implements FromView, ShouldAutoSize
{

    public function __construct()
    {
    }
    public function view(): View
    {
        $prestasi = Prestasi::with(['mahasiswa', 'media'])->get();
        return view('exports.Exports', compact('prestasi'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getFont()->setBold('true');
                $event->sheet->insertImage('A1', public_path('LOGOTEDC.PNG'));
            },
        ];
    }
}
