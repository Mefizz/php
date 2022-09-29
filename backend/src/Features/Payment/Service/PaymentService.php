<?php

declare(strict_types=1);

namespace App\Features\Payment\Service;


use App\Features\Payment\Repository\PaymentRepository;


class PaymentService
{

    public function __construct(public PaymentRepository $userRepository)
    {
    }


}