<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class subcategoryRequest extends FormRequest
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
            'photo'=>'required_without:ph|mimes:jpg,jpeg,png',
            'category_id'=>'required|exists:main_categories,id',
            'subcaegory.*.name'=>'required|string',
            'subcaegory.*.translation_lang'=>'required',
            'subcaegory' =>'required|array|min:1',

        ];
    }

    public function messages()
    {
        return[
          'required' =>'هذا الحقل مطلوب',
          'photo.required_without'=>'يجب اضافة صورة '  ,
          'photo.mimes'=>' jpg,png,jpeg يجب ان يكون نوع الصور ' ,
          'string'=>'يجب ان يكون المدخل حروف ' ,

        ];
    }
}
