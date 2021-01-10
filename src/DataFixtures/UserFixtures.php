<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i = 0; $i < 5;$i++) {
            $user = new User();
            $user->setFirstName($faker->name);
            $user->setLastName($faker->lastName);
            $user->setUsername("technicien-".$faker->userName);
            $user->setRoles(['ROLE_USER']);
            $user->setSexe($faker->randomElement(["Homme", "Femme"]));
            $user->setDateDeNaissance($faker->dateTimeBetween());
            $encrypted = $this->passwordEncoder->encodePassword($user, 'test');
            $user->setPassword($encrypted);
            $manager->persist($user);

            $admin = new User();
            $admin->setFirstName($faker->name);
            $admin->setLastName($faker->lastName);
            $admin->setUsername('ingenieur-'.$faker->userName);
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setSexe($faker->randomElement(["Homme", "Femme"]));
            $admin->setDateDeNaissance($faker->dateTimeBetween());
            $encrypted = $this->passwordEncoder->encodePassword($user, 'admin');
            $admin->setPassword($encrypted);
            $manager->persist($admin);
        }


        $manager->flush();
    }
}
