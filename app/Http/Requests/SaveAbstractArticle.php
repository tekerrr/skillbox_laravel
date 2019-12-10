<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAbstractArticle extends FormRequest
{
    public function rules()
    {
        return [
            'slug' => [
                'required' ,
                'regex:/^[\w\-]+$/',
            ],
            'title' => 'required|min:5|max:100',
            'abstract' => 'required|max:255',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => 'Поле "Символьный код" обязательно для заполнения',
            'slug.regex' => 'Поле "Символьный код" должно состоять только из латинских символов, цифр, символов тире и подчеркивания',
            'slug.unique' => 'Поле "Символьный код" должно быть уникальным',
            'title.required' => 'Поле "Название" обязательно для заполнения',
            'title.min' => 'Поле "Название" должно быть не менее 5 символов',
            'title.max' => 'Поле "Название" должно быть не более 100 символов',
            'abstract.required' => 'Поле "Краткое описание" обязательно для заполнения',
            'abstract.max' => 'Поле "Краткое описание" должно быть не более 255 символов',
            'body.required' => 'Поле "Детальное описание" обязательно для заполнения',
        ];
    }

    public function getTags()
    {
        return explode(', ', $this->get('tags'));
    }
}
