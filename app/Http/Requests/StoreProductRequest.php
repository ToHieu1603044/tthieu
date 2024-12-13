<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * 
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
            'quantity'             =>'required', 
            'size'              =>'required',
            'color'              =>'required',
            'img'               =>'image|max:2048'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('message.required', ['attribute' => 'Tên sản phẩm']),
            'price_buy.required' => __('message.required', ['attribute' => 'Giá nhập']),
            'price_sell.required' => __('message.required', ['attribute' => 'Giá bán']),
            'stock.required' => __('message.required', ['attribute' => 'Số lượng']),
            'category_id.required' => __('message.required', ['attribute' => 'Danh mục']),
            'description.required' => __('message.required', ['attribute' => 'Mô tả']),
            'img.required' => __('message.required', ['attribute' => 'Hình ảnh']),
        ];
    }
}
