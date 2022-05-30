<?php
/**
 * Sales repository.
 */

namespace App\Repository;

use App\Entity\Add;
use App\Entity\Sales;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SalesRepository.
 *
 * @method Sales|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sales|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sales[]    findAll()
 * @method Sales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Sales>
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 */
class SalesRepository extends ServiceEntityRepository
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
     * SalesRepository Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sales::class);
    }

    /**
     * Query all records.
     *
     * @param array<string, int>    $filters    Filters array
     *
     * @return QueryBuilder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select('sales', 'category', 'partial adds.{id, name}', 'user')
            ->join('sales.category', 'category')
            ->join('sales.author', 'user')
            ->leftJoin('sales.adds', 'adds')
            ->orderBy('sales.createdAt', 'DESC');
        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Query sales by author.
     *
     * @param User                  $user       User entity
     * @param array<string, int>    $filters    Filters array
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('sales.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
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
        return $queryBuilder ?? $this->createQueryBuilder('sales');
    }

    /**
     * Save entity.
     *
     * @param Sales $sales Sales entity
     */
    public function save(Sales $sales): void
    {
        $this->_em->persist($sales);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Sales $sales Sales entity
     */
    public function delete(Sales $sales): void
    {
        $this->_em->remove($sales);
        $this->_em->flush();
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder $queryBuilder Query builder
     * @param array        $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['adds']) && $filters['adds'] instanceof Add) {
            $queryBuilder->andWhere('adds = :adds')
                ->setParameter('adds', $filters['adds']);
        }

        return $queryBuilder;
    }
}