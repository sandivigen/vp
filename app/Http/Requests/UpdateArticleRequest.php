<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateArticleRequest extends Request
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
            'title' => 'required',
//            'category' => 'required',
//            'thumbnail' => 'required',
            'text' => 'required',
//            'video_id' => 'required',
//            'start_video' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Вы не указали заголовок статьи',
//            'category.required' => 'Вы не выбрали категорию',
            'text.required' => 'Вы не внесли текст статьи, пожалуйста дайте краткое описание статьи',
//            'thumbnail.required' => 'Вы не загрузили изображение, пожалуйста загрузите изображение для ',
//            'video_id.required' => 'Вы не внесли текст статьи, пожалуйста дайте краткое описание статьи',
        ];
    }
}
