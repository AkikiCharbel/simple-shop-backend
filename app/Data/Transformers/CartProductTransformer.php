<?php

namespace App\Data\Transformers;

use App\Data\Resource\CartData;
use App\Data\Resource\ProductData;
use App\Models\Cart;
use App\Models\Product;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class CartProductTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): array
    {
        $var = [];
            $value = json_decode($value, true);

        if (isset($value['cart_model']) && $value['cart_model'] == Cart::class && isset($value['cart_id'])) {
            $cart = Cart::query()->find($value['cart_id']);
            $var['cart'] = CartData::from($cart)->except('products');
        }

        if (isset($value['product_model']) && $value['product_model'] == Product::class && isset($value['product_id'])) {
            $product = Product::query()->find($value['product_id']);
            $var['product'] = ProductData::from($product);
        }

        return $var;
    }
}
