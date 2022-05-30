<?php
/**
 * Adds service interface.
 */

namespace App\Service;

use App\Entity\Add;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface AddsServiceInterface.
 */
interface AddsServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Add $add Add entity
     */
    public function save(Add $add): void;
}
