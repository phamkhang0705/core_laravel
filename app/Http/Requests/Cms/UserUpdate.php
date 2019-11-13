<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
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
        $id = request()->get('global_user_id');

        return [
            // 'nick_name' => 'required|max:50|min:5',
            // 'phone' => 'max:15',
            // 'email' => 'nullable|email|max:100',
            'date_of_birth'=>'nullable|date',
            //'facebook_id'=>'nullable|numeric|max:99999999999999999999',
            'gender'=>'',           
            'status'=>'',
            // 'email' => 'email|required|unique:mysql_merchant.biz_account,email,' . $id . ',biz_account_id|max:128', 
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nick_name.required' => 'Tên người  chưa được nhập', 
            'nick_name.max' => 'Tên người chứa tối đa 50 ký tự',
            'nick_name.min' => 'Tên người chứa tối thiểu 5 ký tự',
            
            'phone.required' => 'SĐT chưa được nhập', 
            'phone.max' => 'SĐT chứa tối đa 15 ký tự',
            
            'email.required' => 'Tên người chưa được nhập', 
            'email.email' => 'Email không hợp lệ',
            'email.max' => 'Email chứa tối đa 100 ký tự',
             
            'date_of_birth.date' => 'Ngày sinh không đúng định dạng', 
            'facebook_id.numeric' => 'Facebook id không đúng định dạng số', 
            'facebook_id.max' => 'Facebook id vượt quá giới hạn',              
        ];
    }
}
