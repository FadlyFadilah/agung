<?php

namespace App\Http\Requests;

use App\Models\Prestasi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePrestasiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('prestasi_edit');
    }

    public function rules()
    {
        return [
            'mahasiswa_id' => [
                'required',
                'integer',
            ],
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
            'status' => [
                'required',
            ],
        ];
    }
}