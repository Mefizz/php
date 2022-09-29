<?php

namespace App\Controller\Api\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use App\Application\Http\ApiResponse;

class UserController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @OA\Get(path="/api/account",summary="Profile info",operationId="get-profile-info", tags={"User"},

     *     @OA\Response(response=200, description="
    id:'int'
    account_id: 'int'
    email: 'string'
    balance: 'float'
    token:'string'")
     * )
     */
    #[Route('/account', name: 'getInfo')]
    public function getInfo(): ApiResponse
    {
        $userEnt = $this->getUser();
        $user = $userEnt->jsonSerialize();

        return ApiResponse::successful('', $user);
    }

}
