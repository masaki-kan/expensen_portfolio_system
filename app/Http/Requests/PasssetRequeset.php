<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PassRule;

class PasssetRequeset extends FormRequest
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
            'email' => ['required','email'],
            'password_first' => ['required'],
            'password' => ['required','confirmed',new PassRule],
            'password_confirmation' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            //
            'email.required' => 'アドレスを入力してください。',
            'password_first.required' => '初期パスワードを入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.confirmed' => '確認用パスワードと一致しません。',
            'password_confirmation.required' => '確認用パスワードを入力してください。',
        ];
    }

}
