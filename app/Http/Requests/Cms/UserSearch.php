<?php

namespace App\Http\Requests\Cms;

use Illuminate\Foundation\Http\FormRequest;

class UserSearch extends FormRequest
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
            'userid' => 'nullable|numeric|max:99999999999999999999',
            'phone' => 'nullable|max:50',
            'email' => 'nullable|email|max:100',
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
            'userid.numeric' => 'User id chỉ nhập số',
            'userid.max' => 'User id có giá trị tối đa 99999999999999999999',
             
            'phone.max' => 'SĐT chứa tối đa 15 ký tự',
             
            'email.email' => 'Email không hợp lệ',
            'email.max' => 'Email chứa tối đa 100 ký tự',          
        ];
    }
}
