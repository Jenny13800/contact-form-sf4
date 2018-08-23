<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexAction()
    {
        return $this->render('website/index.html.twig', [
            'controller_name' => 'WebsiteController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request, ObjectManager $manager){

        $message = new Message();

        $form = $this->createForm(ContactType::class, $message);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $message->setIsTreated(false)
                    ->setCreatedAt(new \DateTime());

            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('accueil');
        }

        $formView = $form->createView();

        return $this->render('website/contact.html.twig', [
                'form' => $formView
            ]);
    }
}
