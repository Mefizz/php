<?php

namespace App\Controller\Api\User;

use App\Application\Service\Auth\AuthService;
use App\Features\User\UseCase\Login\{Command as LoginCommand, Handler as LoginHandler};
use App\Features\User\UseCase\Registration\{Command as RegistrationCommand, Handler as RegistrationHandler};
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Http\ApiResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Auth")
 **/
#[Route('/user', 'user')]
class AuthController extends AbstractController
{
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * @OA\Post(path="/api/user/registration",summary="Registration",operationId="registration", tags={"Auth"},security={},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="email",type="string"),
     *                  @OA\Property(property="password", type="string"),
     *                  required={"email", "password"},
     *                  uniqueItems=true))),
     *              @OA\Response(response=500, description="email:This value is not a valid email;
     *                                         password:This value is too short. It should have 8
     *                                         characters or more."),
     *              @OA\Response(response=200, description="Successful registered"))
     * @throws NonUniqueResultException
     */
    #[Route('/registration', name: 'registration', methods: ['POST'])]
    public function registration(RegistrationCommand $command, RegistrationHandler $handler): Response
    {
        $registeredUser = $handler->handle($command);

        return ApiResponse::successful('Successful registered', $this->authService->authorize($registeredUser));
    }

    /**
     * @OA\Post(path="/api/user/login",summary="Login",operationId="login", description="Live time token 5 minutes",
     *                                                                      tags={"Auth"},security={},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="email",type="string"),
     *                  @OA\Property(property="password", type="string"),
     *
     *                  required={"email", "password"}))),
     *     @OA\Response(response=200, description="Token data"),
     *     @OA\Response(response=403, description="Bad credentials, please verify that your email/password are
     *                                correctly set"))
     *
     * @throws NonUniqueResultException
     */
    #[Route('/login', name: 'user.login')]
    public function login(LoginCommand $command, LoginHandler $handler): ApiResponse
    {
        $userInfo = $handler->handle($command);

        return ApiResponse::successful('Login successful', $userInfo);
    }
}
