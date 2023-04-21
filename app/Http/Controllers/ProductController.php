<?php

namespace App\Http\Controllers;

use App\Data\Resource\ProductData;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return ProductData::collection(
            Product::query()
                ->paginate($request->input('limit', 5))
        );
    }

    public function addToCart(Request $request, Product $product): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if (! $user->carts()->exists()) {
            $user->carts()->create();
        }
        /** @var Cart $cart */
        $cart = $user->carts()->first();

        if (! $cart->products()->where('products.id', $product->id)->exists()) {
            $cart->products()->attach($product->id, ['quantity' => 1]);
        }

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
        ], Response::HTTP_ACCEPTED);
    }
}
