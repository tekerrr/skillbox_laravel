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
}
