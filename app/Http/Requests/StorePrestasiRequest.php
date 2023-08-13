<?php

namespace App\Http\Requests;

use App\Models\Prestasi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePrestasiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('prestasi_create');
    }

    public function rules()
    {
        return [
            'nama_lomba' => [
                'string',
                'required',
            ],
            'bidang_lomba' => [
                'required',
            ],
            'tanggal_pelaksanaan' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'tempat_pelaksanaan' => [
                'string',
                'required',
            ],
            'prestasi_juara' => [
                'string',
                'required',
            ],
            'tingkat' => [
                'string',
                'required',
            ],
            'sertifikat' => [
                'required',
            ],
        ];
    }
}