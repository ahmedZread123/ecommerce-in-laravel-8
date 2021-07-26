<?php

namespace App\Http\Requests;

use App\Models\vendor;
use Illuminate\Foundation\Http\FormRequest;

class vendorRequest extends FormRequest
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

            'name'=>'required|string|max:100',
        	'mobile'=>'required|integer|unique:vendors,mobile,'.$this->id,
        	'email'=>'required|email|unique:vendors,email,'.$this->id,
        	'category_id'=>'required|integer|exists:main_categories,id',
        	'address'=>'required|string',
        	'logo'=>'required_without:log|mimes:jpg,jpeg,png',
            'password'=>'required_without:pass',
            // 'subcategory_id'=>'required|integer|exists:subcategories,id',
            
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'مطلوب اضافة الاسم ' ,
            'name.string'=>'يجب ان يكون الاسم حروف ',
            'name.max'=>' يجب ان لا يتجاوز الاسم  100حرف ',
            'mobile.integer'=>'يجب ان يتكون رقم الهاتف من ارقام فقط ' ,
            'mobile.max'=>'يجب ان كون عدد الرقم اقل من 11',
            'mobile.required'=>'مطلوب اضافة رقم الهاتف ' ,
            'email.email'=>'يرجا اضافة بريد الكتروني صحيح ',
            'email.required'=>'  هذا الحقل مطلوب ',
            'unique'=>'هذا البيانات مستخدمة من قبل ',
            'category_id.required'=>'هذا الحقل مطلوب ',
            'category_id.integer'=>'هذا الحقل مطلوب ارقام',
            'address.required'=>'هذا الحقل مطلوب ',
            'address.string'=>'هذا الحقل مطلوب حروف',
            'logo.mimes'=>'يرجى التحقق من نوع الملف يجب ان يكون jpg,jpeg,png',
            'logo.required_without'=>'يجب اضافة صورة   ',
            'password.required'=>'مطلوب اضافة كلمة المرور ' ,
            'password.min'=>' يجيب ان تكون كلمة المرور اكبر من 6 حروف او ارقام ' ,
        ];
    }
}
