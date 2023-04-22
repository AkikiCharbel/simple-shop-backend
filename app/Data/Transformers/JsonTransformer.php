<?php

namespace App\Data\Transformers;

use App\Data\Resource\CartData;
use App\Data\Resource\ProductData;
use App\Models\Cart;
use App\Models\Product;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class JsonTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): array
    {
        return json_decode($value, true);
    }
}
