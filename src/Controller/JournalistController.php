<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JournalistController extends AbstractController
{
    /**
     * @Route("/journalist", name="journalist")
     */
    public function index()
    {
        $count = $this->getDoctrine()->getRepository(Articles::class)->count([]);
        return $this->render('journalist/index.html.twig', [
            'controller_name' => 'JournalistController',
            'count'=>$count
        ]);
    }
}
