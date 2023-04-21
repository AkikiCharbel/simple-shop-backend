<?php

namespace App\Http\Controllers;

use App\Data\Resource\CartData;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(): CartData
    {
        /** @var User $user */
        $user = Auth::user();

        return CartData::from($user->carts()->first());
    }

    public function removeFromCart(Cart $cart, Product $product, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->carts()->where('id', $cart->id)->exists()) {
            throw new BadRequestHttpException('This card doesn\'t belong to this user.');
        }

        if (! $cart->products()->where('products.id', $product->id)->exists()) {
            throw new BadRequestHttpException('Cannot find the product in the cart');
        }

        $cart->products()->detach($product->id);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
        ], Response::HTTP_ACCEPTED);
    }

    public function buy(Cart $cart, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user->carts()->where('id', $cart->id)->exists()) {
            throw new BadRequestHttpException('This card doesn\'t belong to this user.');
        }

        $totalPrice = $cart->products()->sum('price');
        $cart->total_price = (int) $totalPrice;
        $cart->save();
        $cart->delete();

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
        ], Response::HTTP_ACCEPTED);
    }
}
