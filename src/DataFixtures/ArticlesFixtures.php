<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ArticlesFixtures extends Fixture
{

    private $encoder;

    public function __construct( UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $tab2 = array(
            array(
                'titre' => 'mon super article',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur consequuntur ducimus eaque facilis iste labore magni obcaecati perspiciatis porro, praesentium recusandae similique voluptate voluptatem. Debitis dolor doloremque ex qui reprehenderit.',
                'journalist_id' => null, 'picture' => 'image1.jpg'),
            array(
                'titre' => 'un deuxième article top',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur consequuntur ducimus eaque facilis iste labore magni obcaecati perspiciatis porro, praesentium recusandae similique voluptate voluptatem. Debitis dolor doloremque ex qui reprehenderit.',
                'journalist_id' => null, 'picture' => 'image2.jpg'),
            array(
                'titre' => 'un article passable',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur consequuntur ducimus eaque facilis iste labore magni obcaecati perspiciatis porro, praesentium recusandae similique voluptate voluptatem. Debitis dolor doloremque ex qui reprehenderit.',
                'journalist_id' => null, 'picture' => 'image3.jpg')
        );

        foreach($tab2 as $row)
        {

            $article = new Articles();
            $article->setTitre($row['titre']);
            $article->setContent($row['content']);
            $article->setPicture($row['picture']);
            $article->setJournalist($row['journalist_id']);

            $manager->persist($article);
        }

        $manager->flush();
    }
}