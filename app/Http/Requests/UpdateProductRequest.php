<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $id = $this->route('product')->id;
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
}
