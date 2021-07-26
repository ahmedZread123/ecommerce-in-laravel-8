<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class producterequest extends FormRequest
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
            'name'       => 'required|string',
            'contact'	 => 'required|string' ,
            'price'      => 'required',     
            'namber'      => 'required',     
            'photo'	     => 'required_without:ph|mimes: jpg,png,jpeg', 
            'vendor_id'  => 'required|exists:vendors,id',
         'subcategory_id'=> 'required|exists:subcategories,id',

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
