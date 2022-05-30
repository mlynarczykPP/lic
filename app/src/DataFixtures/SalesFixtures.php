<?php
/**
 * Sales fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Sales;
use App\Entity\Categories;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class SalesFixtures.
 */
class SalesFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(10, 'sales', function (int $i) {
            $sales = new Sales();
            $sales->setTitle($this->faker->randomElement($array = array ('4u', '2u', '4NEO', 'PM40', 'PM50', 'PM60', 'PM80')));
            $sales->setAcc($this->faker->numberBetween(0,200));
            $sales->setSmartphone($this->faker->numberBetween(0,1));
            $sales->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $sales->setCategory($this->getRandomReference('categories'));

            $adds = $this->getRandomReferences(
                'adds',
                $this->faker->numberBetween(2,3)
            );

            foreach ($adds as $adds) {
                $sales->addAdd($adds);
            }

            $author = $this->getRandomReference('users');
            $sales->setAuthor($author);

            return $sales;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoriesFixtures::class, 1: AddsFixtures::class, 2: UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoriesFixtures::class, AddsFixtures::class, UserFixtures::class];
    }
}
