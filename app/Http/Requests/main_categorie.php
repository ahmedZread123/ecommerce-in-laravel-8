<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class main_categorie extends FormRequest
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
            'caegory' =>'required|array|min:1',
            'caegory.*.name' =>'required',
           // 'caegory.*.active' =>'required',
            'caegory.*.translation_lang' =>'required',
            
            'photo'=>'required_without:id|mimes:jpg,jpeg,png',
             
        ];
    }
}
