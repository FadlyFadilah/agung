<?php

namespace App\Http\Requests;

use App\Models\Prestasi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPrestasiRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('prestasi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:prestasis,id',
        ];
    }
}