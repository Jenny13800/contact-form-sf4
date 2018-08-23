<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(MessageRepository $repository)
    {
        // récupère les messages du plus récent au plus ancien
        $messages = $repository->findByDate();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(){
        return $this->render('admin/login.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){}

}
