<?php
/**
 * Sales service.
 */

namespace App\Service;

use App\Entity\Sales;
use App\Entity\User;
use App\Repository\SalesRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class SalesService.
 */
class SalesService implements SalesServiceInterface
{
    /**
     * Sales repository.
     */
    private SalesRepository $salesRepository;

    /**
     * Adds service.
     */
    private AddsService $addsService;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param SalesRepository       $salesRepository    Sales repository
     * @param AddsService           $addsService        Adds service
     * @param PaginatorInterface    $paginator          Paginator
     */
    public function __construct(SalesRepository $salesRepository, AddsService $addsService, PaginatorInterface $paginator)
    {
        $this->addsService = $addsService;
        $this->salesRepository = $salesRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int                   $page       Page number
     * @param User                  $author     Author
     * @param array<string, int>    $filters    Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->salesRepository->queryByAuthor($author, $filters),
            $page,
            SalesRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list for Admin.
     *
     * @param int                   $page       Page number
     * @param array<string, int>    $filters    Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListAdm(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->salesRepository->queryAll($filters),
            $page,
            SalesRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Sales $sales Sales entity
     */
    public function save(Sales $sales): void
    {
        if (null == $sales->getId()) {
            $sales->setCreatedAt(new \DateTimeImmutable());
        }

        $this->salesRepository->save($sales);
    }

    /**
     * Delete sale.
     *
     * @param Sales $sales Sales entity
     */
    public function delete(Sales $sales): void
    {
        $this->salesRepository->delete($sales);
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['adds_id'])) {
            $add = $this->addsService->findOneById($filters['adds_id']);
            if (null !== $add) {
                $resultFilters['adds'] = $add;
            }
        }

        return $resultFilters;
    }
}
