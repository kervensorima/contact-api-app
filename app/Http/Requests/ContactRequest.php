<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => "bail|required|min:2|max:250", 
            "last_name" => "bail|required|min:2|max:250", 
            "email" => "bail|required|email|min:10|max:255",
            "phone_number" => "bail|required|min:8|max:250",
            "address" => "bail|required|min:2|max:250",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'errors' => $validator->errors(),
                "success" =>  false,
                "message" => "Validation errors",
            ],
            400
        ));
    }


    //  to change the validations messages
    /*************  ✨ Codeium Command 🌟  *************/
    public function messages()
    {
        return [
            'first_name.required' => 'The first name field is required.',
        ];
    }
}
