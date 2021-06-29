<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BoxCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'order' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルを入力してください',
            'order.integer' => '挿入したい番号は数字で入力してください',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response['status']  = 'NG';
        $response['summary'] = 'Failed validation.';
        $response['errors']  = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}