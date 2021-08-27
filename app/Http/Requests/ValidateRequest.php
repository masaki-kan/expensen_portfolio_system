<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Rules\TelRule;
use Auth;

class ValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        //authorize()はこのFormRequestを認可するかどうか trueなら認可 falseなら却下
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
            'email' => ['required', 'email', 'unique:users'],
            'tel' => ['required', new TelRule()],
            'sex' => ['required'],
            'service' => ['required'],
            'master_flag' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            //
            'name.required' => "名前を入力してください。",
            'email.required' => "メールアドレスを入力してください。",
            'email.email' => "入力されたメールアドレスが正しくありません。",
            'email.unique' => "入力されたメールアドレスはすでに存在しています。",
            'tel.required' => "電話番号を入力してください。",
            'sex.required' => "性別を選択してください。",
            'service.required' => "業務形態を選択してください。",
            'master_flag.required' => "権限を選択してください。",
        ];
    }
}
