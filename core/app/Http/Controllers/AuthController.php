<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\LoggedInUserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    /**
     * Login a user.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     *
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    #[OAT\Post(
        tags: ['auth'],
        path: '/api/login',
        summary: 'Login a user',
        operationId: 'AuthController.login',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/LoginRequest')

        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/LoggedInUserResource')
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
                description: 'Unprocessable entity',
                content: new OAT\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return abort(401, 'Invalid credentials.');
        }

        return Response::json(new LoggedInUserResource($user));
    }

    /**
     * Logout a user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    #[OAT\Post(
        tags: ['auth'],
        path: '/api/logout',
        summary: 'Logout a user',
        operationId: 'AuthController.logout',
        security: [['BearerToken' => []]],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_NO_CONTENT,
                description: 'No content'
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
