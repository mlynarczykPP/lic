<?php
/**
 * Adds service.
 */

namespace App\Service;

use App\Entity\Add;
use App\Repository\AddRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AddsService.
 */
class AddsService implements AddsServiceInterface
{
    /**
     * Sales repository.
     */
    private AddRepository $addRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param AddRepository     $addRepository Task repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(AddRepository $addRepository, PaginatorInterface $paginator)
    {
        $this->addRepository = $addRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->addRepository->queryAll(),
            $page,
            AddRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Add $add Add entity
     */
    public function save(Add $add): void
    {
        if (null == $add->getId()) {
            $add->setCreatedAt(new \DateTimeImmutable());
        }

        $this->addRepository->save($add);
    }

    /**
     * Delete note.
     *
     * @param Add $add Add entity
     */
    public function delete(Add $add): void
    {
        $this->addRepository->delete($add);
    }

    /**
     * Find by id.
     *
     * @param int $id Add id
     *
     * @return Add|null Add entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Add
    {
        return $this->addRepository->findOneById($id);
    }
}
