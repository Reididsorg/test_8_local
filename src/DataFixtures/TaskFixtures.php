<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();
        $faker = Factory::create('fr-FR');

        for ($i = 1; $i < 21; $i++) {
            $taskTitle = 'Tâche ' . $i;
            $task = new Task();
            $task->setCreatedAt(new \DateTime("now"));
            $task->setTitle($taskTitle);
            $task->setContent($faker->sentence(8) . ' ' . $i);
            $task->toggle($faker->boolean()); // Set random boolean value to isDone attribute
            $task->setUser($faker->randomElement($users));
            $manager->persist($task);
            $this->addReference('Trick '.$i, $task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [
            UserFixtures::class,
        ];
    }
}