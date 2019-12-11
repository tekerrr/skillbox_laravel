<?php

namespace App\Http\Requests;

class StorePost extends SaveAbstractArticle
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['slug'][] = 'unique:' . (new \App\Post())->getTable() . ',slug';

        return $rules;
    }
}
