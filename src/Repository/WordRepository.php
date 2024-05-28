<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Word>
 *
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    /**
     * @return Word[] Returns an array of Lesson objects
     */
    public function findWordsByLesson($id): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.lesson = :id')
            ->setParameter('id', $id)
            ->orderBy('w.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Word[] Returns an array of Word objects
     */
    public function findWordsByUser($id): array
    {
        return $this->createQueryBuilder('w')
            ->innerJoin('w.users', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->orderBy('w.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function remove(Word $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    public function findOneBySomeField($value): ?Word
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
