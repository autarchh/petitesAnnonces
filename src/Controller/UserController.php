<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    
}

/**
     * @Route("/annonce/ajout", name="annonce_ajout")
     */
    public function ajoutAnnonce(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class ,$annonce);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $annonce->setUsers($this->getUser());
            $annonce->setActive(False);

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('user_home');
        }


        return $this->render('user/annonce/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
