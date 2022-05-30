<?php
/**
 * Note entity.
 */

namespace App\Entity;

use App\Repository\NoteRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Note.
 *
 * @psalm-suppress MissingConstructor
 *
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 * @ORM\Table("notes")
 */
class Note
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     */
    private $title;

    /**
     * Comment.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     */
    private $comment;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Number.
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     */
    private $number;

    /**
     * Author.
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $author;

    /**
     * Getter for the Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for the Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for the Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for the Comment.
     *
     * @return string|null Comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Setter for the Comment.
     *
     * @param string $comment Comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Getter for the Created at.
     *
     * @return DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for the Created at.
     *
     * @param DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for the Number.
     *
     * @return string|null Number
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * Setter for the Number.
     *
     * @param string $number Number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * Getter for the Author.
     *
     * @return User|null User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for the Author.
     *
     * @param User|null $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
}
