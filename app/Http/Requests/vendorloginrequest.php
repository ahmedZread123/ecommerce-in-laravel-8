<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class vendorloginrequest extends FormRequest
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
            'email'     => 'required|email' , 
            'password'  => 'required|string' , 
        ];
    }

    public function messages()
    {
        return[
           'require' =>'هذا الحقل مطلوب ' , 
           'email.email'   =>'يرجا التأكد من صيغة الايميل ' , 
           
        ];
    }
}
