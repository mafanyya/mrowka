<?php

namespace App\Repository;

use App\Entity\LessonSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LessonSection>
 *
 * @method LessonSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method LessonSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method LessonSection[]    findAll()
 * @method LessonSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LessonSection::class);
    }

    public function remove(LessonSection $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return LessonSection[] Returns an array of LessonSection objects
     */
    public function findLessonSectionByUniqId($uniqid): ?LessonSection
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.uniqid = :uniqid')
            ->setParameter('uniqid', $uniqid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    public function findOneBySomeField($value): ?LessonSection
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
