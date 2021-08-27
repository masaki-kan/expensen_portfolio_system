<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TelRule;

class UsercreateRequeset extends FormRequest
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
            'email' => ['required','email'],
            'tel' => ['required', new TelRule() ],
            'sex' => ['required'],
            'service' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            //
            'name.required' => "名前を入力してください。",
            'email.required' => "メールアドレスを入力してください。",
            'email.email' => "入力されたメールアドレスが正しくありません。",
            'tel.required' => "電話番号を入力してください。",
            'sex.required' => "性別を選択してください。",
            'service.required' => "業務形態を選択してください。",
        ];
    }
}
