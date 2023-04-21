<?php

namespace App\Http\Controllers;

use App\Data\Resource\UserData;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticatedSessionController extends Controller
{
    public function apiStore(LoginRequest $request): UserData
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials are incorrect')],
            ]);
        }

        /** @var User $user */
        $user = User::query()->where('email', $request->email)->first();

        return UserData::from($user)->additional([
            'meta' => [
                'access_token' => $request->user()->createToken('assessment')->plainTextToken,
            ],
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response|Application|ResponseFactory
    {
        Auth::guard('web')->logout();

        auth()->user()->tokens()->delete();

        return response(['message' => 'accepted'], ResponseAlias::HTTP_ACCEPTED);
    }

    public function verifyToken(Request $request): UserData
    {
        return UserData::from(auth()->user())->additional([
            'meta' => [
                'access_token' => $request->bearerToken(),
            ],
        ]);
    }
}
