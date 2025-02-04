<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'over_name' => ['required', 'string' , 'max:10'],
            'under_name' => ['required', 'string' , 'max:10'],
            'over_name_kana' => ['required', 'string' , 'katakana' , 'max:30'],
            'under_name_kana' => ['required', 'string' , 'katakana' , 'max:30'],
            'mail_address' => ['required', 'email', Rule::unique('users', 'mail_address'), 'max:100'],
            'sex' => ['required', 'in:1,2,3'],
            'old_year'  => ['required', 'integer', 'between:2000,' . now()->year],
            'old_month' => ['required', 'between:1,12'],
            'old_day'   => ['required', 'between:1,31'],
            'role' => ['required', 'in:1,2,3,4'],
            'password' => ['required', 'between:8,30', 'confirmed'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $year = $this->input('old_year');
            $month = $this->input('old_month');
            $day = $this->input('old_day');

            // 実際に存在する日付かチェック
            if (!checkdate($month, $day, $year)) {
                $validator->errors()->add('birth_day', '正しい日付を入力してください。');
            }

            // 2000年1月1日～今日までの範囲かチェック
            $birth_day = sprintf('%04d-%02d-%02d', $year, $month, $day);
            if ($birth_day < '2000-01-01' || $birth_day > now()->format('Y-m-d')) {
                $validator->errors()->add('birth_day', '誕生日は2000年1月1日から今日までの日付を選択してください。');
            }
        });
    }

        public function messages(){
        return [
            'over_name.required' => '※姓は必須です',
            'over_name.string' => '※文字列で入力してください',
            'over_name.max' => '※10文字以内で入力してください',
            'under_name.required' => '※名は必須です',
            'under_name.string' => '※文字列で入力してください',
            'under_name.max' => '※10文字以内で入力してください',
            'over_name_kana.required' => '※セイは必須です',
            'over_name_kana.string' => '※文字列で入力してください',
            'over_name_kana.katakana' => '※カタカナで入力してください',
            'over_name_kana.max' => '※30文字以内で入力してください',
            'under_name_kana.required' => '※メイは必須です',
            'under_name_kana.string' => '※文字列で入力してください',
            'under_name_kana.katakana' => '※カタカナで入力してください',
            'under_name_kana.max' => '※30文字以内で入力してください',
            'mail_address.required' => '※メールアドレスは必須です',
            'mail_address.email' => '※メールアドレスの形式で入力してください',
            'mail_address.unique' => '※このメールアドレスは既に使用されています',
            'mail_address.max' => '※100文字以内で入力してください',
            'sex.required' => '※性別は必須です',

            'old_year.required' => '※年を選択してください',
            'old_year.integer' => '※年は整数で入力してください',
            'old_year.between' => '※2000年から' .now()->year. '年の間で入力してください',
            'old_month.required' => '※月を選択してください',
            'old_month.integer' => '※月は整数で入力してください',
            'old_month.between' => '※1から12の間で入力してください',
            'old_day.required' => '※日を選択してください',
            'old_day.integer' => '※日は整数で入力してください',
            'old_day.between' => '※1から31の間で入力してください',

            'role.required' => '※役職は必須です',
            'password.required' => '※パスワードは必須です',
            'password.between' => '※パスワードは8文字以上,30文字以内で入力してください',
            'password_confirmation.required' => '※パスワード確認は必須です',
            'password_confirmation.between' => '※パスワード確認は8文字以上,30文字以内で入力してください',
            'password_confirmation.confirmed' => '※パスワードと一致していません',
        ];
    }

}
