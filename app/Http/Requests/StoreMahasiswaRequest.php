<?php

namespace App\Http\Requests;

use App\Models\Mahasiswa;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mahasiswa_create');
    }

    public function rules()
    {
        return [
            'nama_lengkap' => [
                'string',
                'required',
            ],
            'nim' => [
                'string',
                'required',
            ],
            'jenis_kelamin' => [
                'required',
            ],
            'prodi_id' => [
                'required',
                'integer',
            ],
        ];
    }
}