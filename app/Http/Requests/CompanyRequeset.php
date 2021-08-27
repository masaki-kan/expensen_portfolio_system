<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TelRule;
use App\Rules\ZipRule;

class CompanyRequeset extends FormRequest
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
            'name' => ['required'],
            'tel' => ['required', new TelRule() ],
            'email' => ['required','email'],
            'zip' => ['required', new ZipRule() ],
            'address' => ['required']
        ];
    }

    public function messages()
    {
        return [
            //
            'name.required' => '会社名は必須です。',
            'tel.required' => '電話番号は必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'アドレスの形式が違います。',
            'zip.required' => '郵便番号は必須です。',
            'address.required' => '住所は必須です。'
        ];
    }
}
