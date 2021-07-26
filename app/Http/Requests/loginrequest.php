<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loginrequest extends FormRequest
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
            'email'=>'required|email',
            'password'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>'البريد الاكتروني مطلوب',
            'email.email'=>'ادخل عنوان بريد الاكتروني صالح',
            'password.required'=>'كلمة المرور مطلوبة'
        ];
    }
}
