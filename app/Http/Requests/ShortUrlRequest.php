<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortUrlRequest extends FormRequest
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
            //
            'url' => 'required|string|url|max:191',
            'shortUrl' => 'nullable|string|min:6|max:191|unique:short_urls,short_url',
            'urlName' => 'nullable|string|max:191',
        ];
    }
}
