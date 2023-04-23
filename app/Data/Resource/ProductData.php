<?php

namespace App\Data\Resource;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public int $price,
        public int $quantity,
        public bool $in_cart,
        public Carbon $created_at,
        public Carbon $updated_at
    ) {
    }

    public static function fromModel(Product $product): self
    {
        //Setting in cart to false
        $inCart = false;
        /** @var User $user */
        $user = Auth::user();

        //Getting the cart of the User logged in
        if ($user->carts()->exists()) {
            /** @var Cart $cart */
            $cart = $user->carts()->first();

            // Checking if the products is already in the cart
            if ($cart->products()->where('products.id', $product->id)->exists()) {
                $inCart = true;
            }
        }

        return new self(
            $product->id,
            $product->name,
            $product->price,
            $product->quantity,
            $inCart,
            $product->created_at,
            $product->updated_at,
        );
    }
}
