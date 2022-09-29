<?php

declare(strict_types=1);

namespace App\Features\Payment\UseCase\Create;

use App\Entity\Payment\Payment;
use App\Features\Payment\Repository\PaymentRepository;
use App\Features\User\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use DomainException;
use App\Entity\Payment\Fields\{Status, Amount};

class Handler
{
    public function __construct(

        private PaymentRepository $paymentRepository,
        private UserRepository    $userRepository
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function handle(Command $command): Payment
    {

        $payment = new Payment(
            new Status(Status::ITEMS['OK']),
            new Amount($command->amount),
            $command->sender,
            $this->userRepository->loadUserById($command->recipientAccountId)
        );

        $this->paymentRepository->save($payment);

        return $payment;
    }
}