<?php
/**
 * Categories fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Categories;

/**
 * Class CategoriesFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class CategoriesFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(2, 'categories', function (int $i) {
            $categories = new Categories();
            $categories->setName($this->faker->unique()->randomElement($array = array ('retencja', 'aktywacja')));
            return $categories;
        });

        $this->manager->flush();
    }
}
