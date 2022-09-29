<?php

declare(strict_types=1);


namespace App\Controller\Api\User;

use App\Application\Http\ApiResponse;
use App\Features\Payment\UseCase\Create\{Command as CreateCommand, Handler as CreateHandler};
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class PaymentController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @OA\Post(path="/api/payment",summary="create payment",operationId="create payment", description="Live time token 5 minutes",
     *                                                                      tags={"Payment"},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="amount",type="float"),
     *                  @OA\Property(property="recipient_account_id", type="int"),
     *
     *                  required={"amount", "recipient_account_id"}))),
     *     @OA\Response(response=200, description="Ok"),
     *     @OA\Response(response=403, description="Wrong data"))
     *
     * @throws NonUniqueResultException
     */
    #[Route('/payment', name: 'payment')]
    public function createPayment(CreateCommand $command, CreateHandler $handler)
    {
        $command->sender = $this->getUser();
        $userInfo = $handler->handle($command);

        return ApiResponse::successful('payment created successfully', $userInfo->jsonSerialize());
    }
}