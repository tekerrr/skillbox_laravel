<?php

namespace App;

trait CanBeBinding
{
    public static function getBindingModel(string $value): self
    {
        abort_if(! $model = (new static())->resolveRouteBinding($value), 404);

        return $model;
    }
}
