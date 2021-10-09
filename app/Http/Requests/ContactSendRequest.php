<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSendRequest extends FormRequest
{
    /**
     * Determines if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Gets the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        return [
            'title' => 'required',
            'store_name' => 'string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'first_name_katakana' => 'required|string',
            'last_name_katakana' => 'required|string',
            'email' => 'required|string|confirmed|email',
            'email_confirmation' => 'required|string',
            'phone' => 'required|string',
            'first_postcode' => 'string',
            'last_postcode' => 'string',
            'prefectures' => 'string',
            'city_country' => 'string',
            'street' => 'string',
            'building_name' => 'string',
            'content' => 'required|string',
        ];
    }
    
    /**
     * Gets the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {   
        return [
            'title.required' => 'タイトルを入力してください。',
            'store_name.required' => '法人名/店舗名を入力してください。',
            'first_name.required' => 'お名前を入力してください。',
            'last_name.required' => 'お名前を入力してください。',
            'first_name_katakana.required' => 'お名前を入力してください。',
            'last_name_katakana.required' => 'お名前を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email_confirmation.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスを入力してください',
            'email.confirmed' => '電子メールの確認が一致しません。',
            'phone.required' => 'ご連絡先電話番号を入力してください。',
            'first_postcode.required' => '郵便番号を入力してください。',
            'last_postcode.required' => '郵便番号を入力してください。',
            'prefectures.required' => '都道府県を入力してください',
            'city_country.required' => '市区郡を入力してください',
            'street.required' => '町村字番地を入力してください',
            'building_name.required' => '建物名を入力してください',
            'content.required' => 'お問い合わせ内容を入力してください。',
        ];
    }
}
