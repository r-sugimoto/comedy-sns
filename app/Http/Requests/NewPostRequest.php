<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPostRequest extends FormRequest
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
            'picture_files.*' => 'max:2000|mimes:jpeg,png,jpg,gif',
            'movie_file' => 'max:200000|mimes:mp4,flv,wmv,qt',
        ];
    }

    public function attributes()
    {
        return [
            'picture_files.*' => '画像',
            'movie_file' => '動画',
        ];
    }

    // JSON形式のタグを格納
    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
