<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalenderDetailCreate extends FormRequest
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
            'line' => ['required'],
            'ride' => ['required'],
            'getoff' => ['required'],
            'money' => ['required', 'numeric'],
            'type' => ['required'],
        ];
    }

    public function message()
    {
        return [
            //
            'line.required' => "沿線を選択してください。",
            'ride.required' => "乗車を入力してください。",
            'getoff.required' => "降車を入力してください。",
            'money.required' => "金額を入力してください。",
            'money.numeric' => "金額は数字以外は入力できません。",
            'type.required' => "タイプを選択してください。",
        ];
    }
}
