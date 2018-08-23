<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index(MessageRepository $repository)
    {
        // récupère les messages du plus récent au plus ancien
        $messages = $repository->findByDate();
        dump($messages);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/admin", name="connexion")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(){
        return $this->render('admin/login.html.twig');
    }
}