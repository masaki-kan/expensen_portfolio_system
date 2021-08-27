<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvpitapaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'pitapacsv' => ['required', 'file', 'mimes:csv,txt'] //mimesルールの引数にtxtも渡す
        ];
    }

    public function messages()
    {
        return [
            //
            'pitapacsv.required' => "ファイルをアップロードして下さい。",
            'pitapacsv.mimes' => "csv形式のファイルでアップロードして下さい。",
            'pitapacsv.file' => "csv形式のファイルでアップロードして下さい。",
        ];
    }
}
