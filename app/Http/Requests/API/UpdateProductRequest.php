<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateProductRequest extends FormRequest
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
            'category_id'       =>'required',
            'name'              =>'required|max:255',
            'description'       =>'nullable',
            'price_buy'         =>'required',
            'price_sell'        =>'required',
            'stock'             =>'required', 
            'size'              =>'required',
            'color'              =>'required',
            'img'               =>'image|max:2048'
        ];
    }
    protected function failedValidation(Validator $validator){
        $errors = $validator->errors();

        $response = response()->json([
            'errors' => $errors->messages()
        ],Response::HTTP_BAD_REQUEST); //422

        throw new HttpResponseException($response);
        
    }
}
