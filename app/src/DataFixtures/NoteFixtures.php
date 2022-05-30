<?php
/**
 * Note fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class NoteFixtures.
 */
class NoteFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(10, 'notes', function (int $i) {
            $note = new Note();
            $note->setTitle($this->faker->randomElement($array = array ('4u', '2u', '4NEO', 'PM40', 'PM50', 'PM60', 'PM80')));
            $note->setComment($this->faker->randomElement($array = array (
                'ze smartfonem',
                'zapytac o akcesoria',
                'dokonczyc formalnosci',
                'nie bylo decyzyjnej osoby',
                'kurier nie dotarl',
                'problem z akceptacja umowy',
                'nie moze rozmawiac'
            )));
            $note->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $note->setNumber($this->faker->randomNumber(3, true)." ".$this->faker->randomNumber(3, true)." ".$this->faker->randomNumber(3, true));

            $author = $this->getRandomReference('users');
            $note->setAuthor($author);

            return $note;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
