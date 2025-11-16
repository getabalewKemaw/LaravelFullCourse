<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MoneyCast implements CastsAttributes
{
    // Convert DB → PHP
    public function get($model, string $key, $value, array $attributes)
    {
        return $value / 100;  // cents → birr
    }

    // Convert PHP → DB
    public function set($model, string $key, $value, array $attributes)
    {
        return intval($value * 100); // birr → cents
    }
}
