<?php
/**
 * Created by PhpStorm.
 * User: duyminh
 * Date: 23/09/2019
 * Time: 21:01
 */

namespace App\Http\Requests\Cms;


use Illuminate\Foundation\Http\FormRequest;

class AdminMerchantValidate extends FormRequest
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
            'name' => 'required|max:128',
            'image_url' => 'required',
            'logo_url' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên merchant.',
            'name.max' => 'Tên merchant không vượt quá 128 ký tự',
            'image_url.required' => 'Vui lòng nhập ảnh đại diện merchant',
            'logo_url.required' => 'Vui lòng nhập ảnh logo'
        ];
    }

}