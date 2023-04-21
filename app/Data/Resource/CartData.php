<?php

namespace App\Data\Resource;

use App\Models\Cart;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CartData extends Data
{
    public function __construct(
        public int $id,
        public ?int $total_price,
        public Carbon $created_at,
        public Carbon $updated_at,
        #[DataCollectionOf(ProductData::class)]
        public DataCollection $products
    ) {
    }

    public static function fromModel(Cart $cart): self
    {
        return new self(
            $cart->id,
            $cart->total_price,
            $cart->created_at,
            $cart->updated_at,
            ProductData::collection($cart->products)
        );
    }
}
