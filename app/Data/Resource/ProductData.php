<?php

namespace App\Data\Resource;

use App\Models\Product;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public int $price,
        public int $quantity,
        public Carbon $created_at,
        public Carbon $updated_at
    ) {
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            $product->id,
            $product->name,
            $product->price,
            $product->quantity,
            $product->created_at,
            $product->updated_at,
        );
    }
}
