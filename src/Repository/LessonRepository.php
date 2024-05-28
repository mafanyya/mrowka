<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lesson>
 *
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function remove(Lesson $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Lesson[] Returns an array of LessonSection objects
     */
    public function findLessonByUniqId($uniqid): ?Lesson
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.uniqid = :uniqid')
            ->setParameter('uniqid', $uniqid)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Lesson[] Returns an array of Lesson objects
     */
    public function findLessonsBySection($id): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.lessonSection = :id')
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Lesson[] Returns an array of Lesson objects
     */
    public function findLessonsByUser($id): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.users', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


//    public function findOneBySomeField($value): ?Lesson
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
