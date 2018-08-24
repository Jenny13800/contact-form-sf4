<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(MessageRepository $repository)
    {
        // récupère les messages du plus récent au plus ancien
        $messages = $repository->findByDate();

        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/message/{id}/traitement", name="traitement")
     */
    public function traitementAction(Request $request, Message $message, ObjectManager $manager){
        // regarde la request : recupère la valeur radio button
        $statut = $request->request->get("traite");
        // si statut a la valeur traite
        if($statut == 'traite'){
            // on passe le statut à true pour envoyer dans la base de données
            $statut = true;
            // ajoute la date d'aujourd'hui
            $message->setTreatedAt(new \DateTime());
        } else {
            // passe le statut à false
            $statut = false;
        }
        $message->setIsTreated($statut);
        $manager->persist($message);
        $manager->flush();

        return $this->redirectToRoute('message');
    }
}
