<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserService $userService)
    {
        $user = $userService->registerUser(
            $request->name,
            $request->email,
            $request->password
        );

        return (new UserResource($user))->additional([ 'success' => true ]);
    }
}
