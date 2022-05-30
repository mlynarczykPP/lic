<?php
/**
 * Sales service interface.
 */

namespace App\Service;

use App\Entity\Sales;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface SalesServiceInterface.
 */
interface SalesServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int                   $page       Page number
     * @param User                  $author     Author
     * @param array<string, int>    $filters    Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface;

    /**
     * Get paginated list for Admin.
     *
     * @param int $page Page number
     * @param array<string, int>    $filters    Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListAdm(int $page, array $filters = []): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Sales $sales Sales entity
     */
    public function save(Sales $sales): void;
}
