<?php

namespace App\DataFixtures;
<<<<<<< HEAD
use Faker;
=======
>>>>>>> sall
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
<<<<<<< HEAD
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

=======
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
>>>>>>> sall
class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
<<<<<<< HEAD
       $faker= Faker\Factory::create('fr_FR');
        for($i=0; $i<4; $i++){
            $profil = new Profil();
            $profil->setLibelle($faker->unique()->randomElement(['ADMIN','Formateur','CM','Apprenant']));
=======
        $faker = Faker\Factory::create('fr_FR');
        for($i=0; $i<4; $i++){
            $profil = new Profil();
            $profil->setLibelle($faker->unique()->randomElement(['Admin','Formateur','CM','Apprenant']));
>>>>>>> sall
            $manager->persist($profil);
            $user = new User();
            $harsh = $this->encoder->encodePassword($user, 'sonatel');
            $user->setProfil($profil);
            $user->setUsername($faker->unique()->randomElement(['babacar','aminata','Oumar','Laye']));
            $user->setPassword($faker->randomElement([ $harsh, $harsh, $harsh, $harsh]));
            $user->setPrenom($faker->randomElement(['babacar','aminata','Oumar','Laye']));
            $user->setNom($faker->randomElement(['Diouf','Lo','Enne', 'Sall']));
            $user->setEmail($faker->randomElement(['babacar@sa.sn','aminata@sa.sn','Oumar@sa.sn','laye@sa.sn']));
            $user->setTel($faker->randomElement(['778458574','778548596','774859652','777777777']));
<<<<<<< HEAD
            $user->setArchived($faker->randomElement(['true','false','true','false']));
            $user->setGenre($faker->randomElement(['F','M','F','F']));
            $user->setAvatar('avatar');
=======
            $user->setArchived($faker->randomElement(['true','false','false','true']));
            $user->setGenre($faker->randomElement(['F','F','M','M']));
            $user->setAvatar('avatar','avatar','avatar','avatar');
>>>>>>> sall
            $manager->persist($user);
        }

        $manager->flush();
    }
    
<<<<<<< HEAD
}
=======
}
>>>>>>> sall
