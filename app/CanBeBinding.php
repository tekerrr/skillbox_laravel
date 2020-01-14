<?php


namespace App;


trait CanBeBinding
{
    public static function getBinding(string $value): ?self
    {
        return (new static())->resolveRouteBinding($value);
    }
}
