<?php
/**
 * Note service interface.
 */

namespace App\Service;

use App\Entity\Note;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface NoteServiceInterface.
 */
interface NoteServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     * @param User $author Author
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface;

    /**
     * Get paginated list for Admin.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListAdm(int $page): PaginationInterface;


    /**
     * Save entity.
     *
     * @param Note $note Note entity
     */
    public function save(Note $note): void;
}
