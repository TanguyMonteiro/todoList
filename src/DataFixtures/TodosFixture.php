<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TodosFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $id = 4 ;
        $user = $manager->getRepository(User::class)->find($id);

        for($i=1; $i<50; $i++){

            $todo = new Todo();
            $todo->setDescription('une description bidon');
            $todo->setCreatedAt(new \DateTime());
            $todo->setDueDate(new \DateTime());
            $todo->setUser($user);
            $manager->persist($todo);
        }

        $manager->flush();
    }
}
