<?php
/**
 * Adds repository.
 */

namespace App\Repository;

use App\Entity\Add;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AddRepository
 *
 * @method Add|null find($id, $lockMode = null, $lockVersion = null)
 * @method Add|null findOneBy(array $criteria, array $orderBy = null)
 * @method Add[]    findAll()
 * @method Add[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 5;

    /**
     * NoteRepository Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Add::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('adds.id', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('adds');
    }

    /**
     * Save entity.
     *
     * @param Add $add Add entity
     */
    public function save(Add $add): void
    {
        $this->_em->persist($add);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Add $add Add entity
     */
    public function delete(Add $add): void
    {
        $this->_em->remove($add);
        $this->_em->flush();
    }

    // /**
    //  * @return Add[] Returns an array of Add objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Add
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
