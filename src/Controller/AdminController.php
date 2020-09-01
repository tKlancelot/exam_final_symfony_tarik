<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddJournalistFormType;
use App\Form\EditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $count = $this->getDoctrine()->getRepository(User::class)->count([]);
        return $this->render('admin/index.html.twig', [
            'count' => $count,
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/addJournalist", name="add_journalist")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addJournalist(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $count = $this->getDoctrine()->getRepository(User::class)->count([]);
        $form = $this->createForm(AddJournalistFormType::class, new User());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setEmail($form->get('email')->getData());
            $user->setLastname($form->get('lastname')->getData());
            $user->setFirstname($form->get('firstname')->getData());

            $form = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin');
        } else {
            return $this->render('admin/addJournalist.html.twig', [
                'addUserForm' => $form->createView(),
                'errors' => $form->getErrors(),
                'count' => $count,
            ]);
        }
    }

    /**
     * @Route("/admin/editJournalist/{user}", name="edit_journalist")
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editUser(Request $request, User $user, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder){

        $id = $this->getUser();
        $count = $this->getDoctrine()->getRepository(User::class)->count([]);
        $form = $this->createForm(EditFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $user->setRoles(['ROLE_USER']);
            $form = $form->getData();
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        else{
            return $this->render('admin/editJournalist.html.twig', [
                'updateForm'=>$form->createView(),
                'errors'=>$form->getErrors(true),
                'count'=>$count,
            ]);
        }
    }
//    /**
//     * @Route("/admin/{id}", name="get_journalist")
//     * @param $id
//     * @return Response
//     */
//    public function getOne($id)
//    {
//        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
//        $count = $this->getDoctrine()->getRepository(User::class)->count([]);
//        return $this->render('admin/getJournalist.html.twig', [
//            'user' => $user,
//            'count'=>$count,
//        ]);
//    }

    /**
     * @Route("/admin/{user}", name="delete_journalist")
     */
    public function deleteThis(User $user){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('default');
    }
}


