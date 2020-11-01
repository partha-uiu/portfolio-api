<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
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
        $id = $this->route('id');
        

        return [
            'title' => 'required|unique:portfolios,id,'.$id,
            'category' => 'required',
            'description' => 'required',
            'images' => 'required',
            'images.*' => 'image | mimes:jpeg,png,jpg,gif,svg | max:1000',
        ];
    }
}
