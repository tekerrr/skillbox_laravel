<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateNews extends SaveAbstractArticle
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['slug'][] = Rule::unique($this->news->getTable(), 'slug')->ignore($this->news);

        return $rules;
    }
}
