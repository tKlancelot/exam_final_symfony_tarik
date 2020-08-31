<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\User;
use App\Form\AddArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $count = $this->getDoctrine()->getRepository(Articles::class)->count([]);
        $articles = $this->getDoctrine()->getRepository(Articles::class)->findAll();
        return $this->render('default/index.html.twig', [
            'articles'=>$articles,
            'count'=>$count,
        ]);
    }


    /**
     * @Route("/", name="default")
     * @Route("/default/paginate/{page}", name="default_paginate")
     */
    public function page($page = 1)
    {
        $count = $this->getDoctrine()->getRepository(Articles::class)->count([]);
        $nbrPage = ceil($count / 2);
        $premier = ($page * 2) - 2;

        $articles = $this->getDoctrine()->getRepository(Articles::class)->paginate(2, $premier);

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'page' => $page,
            'nbrPage' => $nbrPage,
            'count'=>$count,
        ]);
    }

    /**
     * @Route("/default/addArticle/{userId}", name="add_article")
     * @param Request $request
     * @param $userId
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addArticle(Request $request, $userId, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
        $idUser = $user->getId();

        $article = new Articles();
        $count = $this->getDoctrine()->getRepository(Articles::class)->count([]);
        $newFilename = null;
        $form = $this->createForm(AddArticleFormType::class, new Articles());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setTitre($form->get('titre')->getData());
            $idJournalist = $article->getJournalist();
            $article->setContent($form->get('content')->getData());
            $uploadPicture = $form->get('picture')->getData();

            if ($uploadPicture) {
                $originalFilename = pathinfo($uploadPicture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadPicture->guessExtension();

                try {
                    $uploadPicture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $article->setPicture($newFilename);
            }
            $form = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('journalist');
        } else {
            return $this->render('default/addArticle.html.twig', [
                'addArticleForm' => $form->createView(),
                'errors' => $form->getErrors(),
                'count'=>$count,
            ]);
        }
    }

    /**
     * @Route("/default/{id}", name="get_detail")
     * @param $id
     * @return Response
     */
    public function getOne($id)
    {
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        $count = $this->getDoctrine()->getRepository(Articles::class)->count([]);

        return $this->render('default/getArticleById.html.twig', [
            'article' => $article,
            'count'=>$count,
        ]);
    }


}
