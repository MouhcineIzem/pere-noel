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
        for ($i = 0; $i < 5; $i++)
        {
            $user = new User();
            $user->setFirstName($i);
            $user->setLastName('User');
            $user->setUsername($user->getLastName().'_'.$user->getFirstName());
            $user->setRoles(['ROLE_USER']);
            $user->setSexe($faker->randomElement(["Homme", "Femme"]));
            $user->setDateDeNaissance($faker->dateTimeBetween('-50 years'));
            $encrypted = $this->passwordEncoder->encodePassword($user, 'test');
            $user->setPassword($encrypted);
            $manager->persist($user);
        }



        // pour l'Admin
        $admin = new User();
        $admin->setFirstName("Pere");
        $admin->setLastName("Noel");
        $admin->setUsername($admin->getLastName().'_'.$admin->getFirstName());
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setSexe("Homme");
        $admin->setDateDeNaissance($faker->dateTimeBetween('-50 years'));
        $encrypted = $this->passwordEncoder->encodePassword($admin, 'admin');
        $admin->setPassword($encrypted);
        $manager->persist($admin);

        // pour Gestion
        $gestion = new User();
        $gestion->setFirstName("Nikole");
        $gestion->setLastName("Gestion");
        $gestion->setUsername($gestion->getLastName().'_'.$gestion->getFirstName());
        $gestion->setRoles(['ROLE_GESTION']);
        $gestion->setSexe("Femme");
        $gestion->setDateDeNaissance($faker->dateTimeBetween('-50 years'));
        $encrypted = $this->passwordEncoder->encodePassword($gestion, 'gestion');
        $gestion->setPassword($encrypted);
        $manager->persist($gestion);


        // pour Secretariat
        $secretariat = new User();
        $secretariat->setFirstName("Caroline");
        $secretariat->setLastName("Secretariar");
        $secretariat->setUsername($secretariat->getLastName().'_'.$secretariat->getFirstName());
        $secretariat->setRoles(['ROLE_SECRETARIAT']);
        $secretariat->setSexe("Femme");
        $secretariat->setDateDeNaissance($faker->dateTimeBetween('-50 years'));
        $encrypted = $this->passwordEncoder->encodePassword($secretariat, 'secretariat');
        $secretariat->setPassword($encrypted);
        $manager->persist($secretariat);


        $manager->flush();
    }
}
