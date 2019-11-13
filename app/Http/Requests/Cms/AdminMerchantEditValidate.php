<?php
/**
 * Created by PhpStorm.
 * User: duyminh
 * Date: 23/09/2019
 * Time: 21:52
 */

namespace App\Http\Requests\Cms;


use Illuminate\Foundation\Http\FormRequest;

class AdminMerchantEditValidate extends FormRequest
{
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
        $id = request()->get('id');

        return [
            'id' => 'required',
            'name' => 'required|max:128',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => 'Không tìm thấy thông tin merchant',
            'name.required' => 'Vui lòng nhập tên merchant.',
            'name.max' => 'Tên merchant không vượt quá 128 ký tự',
        ];
    }

}