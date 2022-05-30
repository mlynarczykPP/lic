<?php
/**
 * Note service.
 */

namespace App\Service;

use App\Entity\Note;
use App\Entity\User;
use App\Repository\NoteRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class NoteService.
 */
class NoteService implements NoteServiceInterface
{
    /**
     * Note repository.
     */
    private NoteRepository $noteRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param NoteRepository     $noteRepository Task repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(NoteRepository $noteRepository, PaginatorInterface $paginator)
    {
        $this->noteRepository = $noteRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int  $page   Page number
     * @param User $author Author
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->noteRepository->queryByAuthor($author),
            $page,
            NoteRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list for Admin.
     *
     * @param int  $page   Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListAdm(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->noteRepository->queryAll(),
            $page,
            NoteRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Note $note Note entity
     */
    public function save(Note $note): void
    {
        if (null == $note->getId()) {
            $note->setCreatedAt(new \DateTimeImmutable());
        }

        $this->noteRepository->save($note);
    }

    /**
     * Delete note.
     *
     * @param Note $note Note entity
     */
    public function delete(Note $note): void
    {
        $this->noteRepository->delete($note);
    }
}
