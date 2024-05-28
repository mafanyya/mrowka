<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function add(User $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(User $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    public function findAllOnline(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.status = 1')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOnlineUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.status = true')
            ->andWhere('u.isAdmin = false')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isAdmin = false')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOnlineAdmins(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.status = true')
            ->andWhere('u.isAdmin = true')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAdmins(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isAdmin = true')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findRegisteredUsersByTime($date): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.register_at >= :date')
            ->setParameter('date', $date)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByEmail($email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
    //    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findOneByUniqId($uniqid): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.uniqid = :val')
            ->setParameter('val', $uniqid)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
