<?php

namespace App\Http\Controllers;

use App\Data\Resource\CartData;
use App\Enums\LogActionsEnum;
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
    public function show(): CartData|JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->carts()->first() != null) {
            return CartData::from($user->carts()->first());
        }

        return response()->json(null, Response::HTTP_ACCEPTED);
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

        $logDescription = [
            'cart_model' => Cart::class,
            'cart_id' => $cart->id,
            'product_model' => Product::class,
            'product_id' => $product->id,
        ];
        activity()
            ->causedBy($user)
            ->performedOn($cart)
            ->event(LogActionsEnum::REMOVED_PRODUCT->name)
            ->log(json_encode($logDescription));

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

        $logDescription = [
            'cart_model' => Cart::class,
            'cart_id' => $cart->id,
        ];

        activity()
            ->causedBy($user)
            ->performedOn($cart)
            ->event(LogActionsEnum::CHECKED_OUT_CART->name)
            ->log(json_encode($logDescription));

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
        ], Response::HTTP_ACCEPTED);
    }
}
