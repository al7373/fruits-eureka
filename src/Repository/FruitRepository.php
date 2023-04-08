<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function add(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFruits(int $page, string $name, string $family): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->select('f')
            ->orderBy('f.name', 'ASC')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10);

        if (!empty($name)) {
            $queryBuilder->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if (!empty($family)) {
            $queryBuilder->andWhere('f.family = :family')
                ->setParameter('family', $family);
        }

        return new Paginator($queryBuilder);
    }

    public function findFavoriteFruits(): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.isFavorite = :isFavorite')
            ->setParameter('isFavorite', true)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Fruit[] Returns an array of Fruit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fruit
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
