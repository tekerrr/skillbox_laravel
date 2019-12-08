<?php

namespace App\Http\Requests;

class StoreNews extends SaveAbstractArticle
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['slug'][] = 'unique:' . (new \App\News())->getTable() . ',slug';

        return $rules;
    }
}
