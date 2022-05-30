<?php
/**
 * User service interface.
 */

namespace App\Service;

use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface AddsServiceInterface.
 */
interface UserServiceInterface
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
     * @param User $user Add entity
     */
    public function save(User $user): void;

    /**
     * Find user by id.
     *
     * @param int $id User id
     *
     * @return User|null User entity
     */
    public function findOneById(int $id): ?User;
}
