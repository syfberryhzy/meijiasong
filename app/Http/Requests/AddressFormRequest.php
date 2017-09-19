<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressFormRequest extends FormRequest
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
           'recevire' => 'required',
          //  'recevire' => 'required|max:10|min:2',
          //  'phone' => 'required|numeric|min:11|max:11',
          //  'areas' => 'required',
          //  'details' => 'required|max:30'
         ];
    }

    public function message()
    {
         return [
             'receiver.required' => '收货人姓名必填',
            //  'receiver.max' => '收货人姓名不能大于10个字',
            //  'receiver.min' => '收货人姓名不能小于2个字',
            //  'phone.required' => '收货人手机号码必填',
            //  'phone.min' => '手机号码格式有误',
            //  'phone.max' => '手机号码格式有误',
            //  'areas.required' => '收货地区必填',
            //  'details.required' => '详细地址必填',
            //  'details.max' => '详细地址不能大于30个字',
         ];
    }
}
