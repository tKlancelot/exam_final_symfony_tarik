<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct( UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $tab = array(
            array('firstname' => 'polo', 'lastname' => 'tulu', 'email' => 'polo@dailyTown.com', 'password' => 'password','roles'=>array(0=>'ROLE_USER')),
            array('firstname' => 'pete', 'lastname' => 'gogo', 'email' => 'pete@dailyTown.com', 'password' => 'password','roles'=>array(0=>'ROLE_USER')),
            array('firstname' => 'joni', 'lastname' => 'miam', 'email' => 'joni@dailyTown.com', 'password' => 'password','roles'=>array(0=>'ROLE_USER')),
            array('firstname' => 'joey', 'lastname' => 'army', 'email' => 'joey@dailyTown.com', 'password' => 'password','roles'=>array(0=>'ROLE_USER')),
            array('firstname' => 'tarik', 'lastname' => 'admin', 'email' => 'tarik@dailyTown.com', 'password' => 'password','roles'=>array(0=>'ROLE_ADMIN')),
        );

        foreach($tab as $row)
        {

            $journalist = new User();
            $journalist->setLastname($row['lastname']);
            $journalist->setFirstname($row['firstname']);
            $journalist->setEmail($row['email']);
            $encoded = $this->encoder->encodePassword($journalist, $row['password']);
            $journalist->setPassword($encoded);
            $journalist->setRoles($row['roles']);

            $manager->persist($journalist);
        }

        $manager->flush();
    }
}