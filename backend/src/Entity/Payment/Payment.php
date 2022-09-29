<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use App\Entity\Payment\Fields\Amount;
use App\Entity\Payment\Fields\Status;
use App\Entity\User\User;
use App\Features\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`payment_payment`")]
class Payment
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Embedded(class: Status::class)]
    private Status $status;

    #[ORM\Embedded(class: Amount::class)]
    private Amount $amount;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $sender;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $recipient;

    public function __construct(
        Status $status,
        Amount $amount,
        User   $sender,
        User   $recipient,

    )
    {
        $this->status    = $status;
        $this->amount    = $amount;
        $this->sender    = $sender;
        $this->recipient = $recipient;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getRecipient(): User
    {
        return $this->recipient;
    }

    public function getSender(): User
    {
        return $this->sender;
    }

    public function jsonSerialize(): array
    {
        return [
            "payment_id"           => $this->getId(),
            "status"               => $this->getStatus()->getValue() === 10 ? 'OK' : 'MEH',
            "amount"               => $this->getAmount()->getValue(),
            "sender_account_id"    => $this->getSender()->getId(),
            "recipient_account_id" => $this->getRecipient()->getId(),
        ];
    }
}