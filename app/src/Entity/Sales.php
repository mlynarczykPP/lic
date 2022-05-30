<?php
/**
 * Sale entity.
 */

namespace App\Entity;

use App\Repository\SalesRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Sale.
 *
 * @psalm-suppress MissingConstructor
 *
 * @ORM\Entity(repositoryClass=SalesRepository::class)
 * @ORM\Table("sales")
 */
class Sales
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
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Smartphone.
     *
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $smartphone;

    /**
     * Accessories.
     *
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $acc;

    /**
     * Category.
     *
     * @ORM\ManyToOne(targetEntity=Categories::class)
     */
    private $category;

    /**
     * Add.
     *
     * @ORM\ManyToMany(targetEntity=Add::class)
     */
    private $adds;

    /**
     * Author id.
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $author;

    /**
     * Sales constructor.
     */
    public function __construct()
    {
        $this->adds = new ArrayCollection();
    }

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
     * Getter for the Smartphone.
     *
     * @return boolean|null Smartphone
     */
    public function getSmartphone(): ?bool
    {
        return $this->smartphone;
    }

    /**
     * Setter for the Smartphone.
     *
     * @param boolean $smartphone Smartphone
     */
    public function setSmartphone(bool $smartphone): void
    {
        $this->smartphone = $smartphone;
    }

    /**
     * Getter for the Accessories.
     *
     * @return int|null Accessories
     */
    public function getAcc(): ?int
    {
        return $this->acc;
    }

    /**
     * Setter for the Accessories.
     *
     * @param int $acc Accessories
     */
    public function setAcc(int $acc): void
    {
        $this->acc = $acc;
    }

    /**
     * Getter for the Category.
     *
     * @return Categories|null Category
     */
    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    /**
     * Setter for the Category.
     *
     * @param Categories|null $category Category
     */
    public function setCategory(?Categories $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for the Adds.
     *
     * @return Collection<int, Add>
     */
    public function getAdds(): Collection
    {
        return $this->adds;
    }

    /**
     * Add adds to the collection.
     *
     * @param Add $add Adds entity
     */
    public function addAdd(Add $add): void
    {
        if (!$this->adds->contains($add)) {
            $this->adds[] = $add;
        }
    }

    /**
     * Remove adds from the collection.
     *
     * @param Add $add
     */
    public function removeAdd(Add $add): void
    {
        $this->adds->removeElement($add);
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
     * @param User|null $author Usaer
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
}