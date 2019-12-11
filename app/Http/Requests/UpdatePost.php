<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdatePost extends SaveAbstractArticle
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['slug'][] = Rule::unique($this->post->getTable(), 'slug')->ignore($this->post);

        return $rules;
    }
}
