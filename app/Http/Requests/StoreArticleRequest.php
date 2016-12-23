<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreArticleRequest extends Request
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
            'category' => 'required',
            'thumbnail' => 'required',
            'text' => 'required',
//            'video_id' => 'required',
//            'start_video' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Не указанно название статьи - пожалуйста укажите заголовок статьи',
            'category.required' => 'Категория не выбрана - пожалуйста выбирите категорию',
            'text.required' => 'Нет текста статьи - пожалуйста внесите краткое описание статьи',
            'thumbnail.required' => 'Изображение не загружено - пожалуйста загрузите миниатюру для статьи',
//            'video_id.required' => 'Вы не внесли текст статьи, пожалуйста дайте краткое описание статьи',
        ];
    }
}
