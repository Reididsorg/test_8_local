<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
//use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    protected EncoderFactoryInterface $encoderFactory;

    public function __construct (
//        EncoderFactoryInterface $encoderFactory
        UserPasswordEncoderInterface $encoder
    )
    {
//        $this->encoderFactory = $encoderFactory;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        Factory::create('fr-FR');

        $user1 = new User();
        $user1->setUserName('Admin');
//        $encoder1 = $this->encoderFactory->getEncoder(User::class);
//        $passwordCrypted1 = $encoder1->encodePassword('1234', '');
        $passwordCrypted1 = $this->encoder->encodePassword($user1, '1234');
        $user1->setPassword($passwordCrypted1);
        $user1->setEmail('admin@admin.fr');
        $user1->setRoles(['ROLE_ADMIN']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUserName('User');
//        $encoder2 = $this->encoderFactory->getEncoder(User::class);
//        $passwordCrypted2 = $encoder2->encodePassword('1234', '');
        $passwordCrypted2 = $this->encoder->encodePassword($user2, '1234');
        $user2->setPassword($passwordCrypted2);
        $user2->setEmail('user@user.fr');
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUserName('Anonymous');
//        $encoder3 = $this->encoderFactory->getEncoder(User::class);
//        $passwordCrypted3 = $encoder3->encodePassword('1234', '');
        $passwordCrypted3 = $this->encoder->encodePassword($user3, '1234');
        $user3->setPassword($passwordCrypted3);
        $user3->setEmail('anonymous@anonymous.fr');
        $user3->setRoles(['IS_AUTHENTICATED_ANONYMOUSLY']);
        $manager->persist($user3);

        $manager->flush();
    }
}