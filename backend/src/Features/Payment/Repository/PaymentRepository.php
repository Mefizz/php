<?php

declare(strict_types=1);

namespace App\Features\Payment\Repository;


use App\Entity\Payment\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry               $registry,
        public EntityManagerInterface $entityManager,
        public PaginatorInterface     $paginator,
        public Connection             $connection,
        public DenormalizerInterface  $denormalizer
    )
    {
        parent::__construct($registry, Payment::class);
    }

    public function save(Payment $payment): void
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
    }


}