<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(10, 'users', function ($i) {
            $user = new User();
            $user->setEmail(sprintf('user%d@callcenter.com', $i));
            $user->setRoles([User::ROLE_USER]);
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'user1234'
                )
            );

            return $user;
        });
        $this->createMany(1, 'admins', function ($i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@callcenter.com', $i));
            $user->setRoles([User::ROLE_ADMIN]);
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'admin1234'
                )
            );

            return $user;
        });
        $this->manager->flush();
    }
}
