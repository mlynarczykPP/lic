<?php
/**
 * Adds fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Add;

/**
 * Class CategoriesFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class AddsFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(4, 'adds', function (int $i) {
            $adds = new Add();
            $adds->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $adds->setName($this->faker->unique()->randomElement($array = array ('PB', 'SC', 'HBO', 'C+')));
            $adds->setComment($this->faker->unique()->randomElement($array = array ('Pakiet Bezpieczeństwa',
                'SmartCare Premium',
                'Kanały HBO',
                'Kanały C+'
            )));
            return $adds;
        });

        $this->manager->flush();
    }
}
