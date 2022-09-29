<?php

namespace App\Application\Service\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestamps
{
    #[ORM\Column(name: "created_at", type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: "update_at", type: "datetime_immutable")]
    private DateTimeImmutable $updatedAt;

    #[ORM\PrePersist]
    public function createdAt(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function updatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}