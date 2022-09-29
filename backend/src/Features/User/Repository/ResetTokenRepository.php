<?php

declare(strict_types=1);

namespace App\Features\User\Repository;

use App\Entity\Token\Reset\ResetToken;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ResetTokenRepository extends ServiceEntityRepository
{
    private const STATUSES = [
        'ACTIVE'  => 10,
        'PENDING' => 7,
        'BLOCKED' => 5,
        'DELETED' => 0,
    ];

    public function __construct(
        public ManagerRegistry        $registry,
        public EntityManagerInterface $entityManager,
        public Connection             $connection,
        public DenormalizerInterface  $denormalizer
    )
    {
        parent::__construct($registry, ResetToken::class);
    }

    public function loadResetTokenByUser(User $user): ?ResetToken
    {
        $resetToken = $this->entityManager->createQueryBuilder()
            ->select('t')
            ->from(ResetToken::class, 't')
            ->innerJoin('t.user', 'u')
            ->where('t.user = :user_id and u.status.value = :status')
            ->setParameter(':user_id', $user->getId())
            ->setParameter(':status', self::STATUSES['ACTIVE'])
            ->getQuery()->setMaxResults(1)->getResult();

        return $resetToken && isset($resetToken[0]) ? $resetToken[0] : null;
    }

    public function save(ResetToken $resetToken): void
    {
        $this->entityManager->persist($resetToken);
        $this->entityManager->flush();
    }

    public function deleteToken(ResetToken $resetToken): void
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->delete(ResetToken::class, 'rest');
        $qb->where('rest = :value');
        $qb->setParameter('value', $resetToken);
        $qb->getQuery()->execute();
    }
}