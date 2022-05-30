<?php
/**
 * User Entity.
 */

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User.
 *
 * @psalm-suppress MissingConstructor
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table("users")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Role user.
     *
     * @var string
     */
    public const ROLE_USER = 'ROLE_USER';

    /**
     * Role user.
     *
     * @var string
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

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
     * First name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     */
    private $firstname;

    /**
     * Last name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=128,
     * )
     */
    private $lastname;

    /**
     * Email.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=180,
     * )
     */
    private $email;

    /**
     * Roles.
     *
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * The hashed password.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

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
     * Getter for the First name.
     *
     * @return string|null First name
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Setter for the First name.
     *
     * @param string $firstname First name
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Getter for the Last name.
     *
     * @return string|null Last name
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Setter for the Last name.
     *
     * @param string $lastname Last name
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Getter for the E-mail.
     *
     * @return string|null E-mail
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for the E-mail.
     *
     * @param string $email E-mail
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Getter for the Roles
     *
     * @return array Roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * Setter for the Roles.
     *
     * @param array $roles Roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Getter for the Password.
     *
     * @see UserInterface
     *
     * @return string|null Password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Setter for the Password.
     *
     * @param string $password Password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string User name
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Getter for the salt.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * Erase.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
