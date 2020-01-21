<?php

namespace App;

trait CanBeBinding
{
    public static function getBindingModel(string $value): self
    {
        $model = (new static())->resolveRouteBinding($value);

        abort_if(! $model, 404);

        return $model;
    }
}
