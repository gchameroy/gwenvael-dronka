<?php

namespace AppBundle\Controller\Website;

use AppBundle\DependencyInjection\Mail\MailContact;
use AppBundle\Form\Type\MessageType;
use AppBundle\Manager\MessageManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="website_contact")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param MessageManager $messageManager
     * @return RedirectResponse|Response
     */
    public function sendMessageAction(Request $request, MessageManager $messageManager, MailContact $mailContact): Response
    {
        $message = $messageManager->getNew();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $messageManager->save($message);
            $mailContact->sendMessage($message);

            return $this->redirectToRoute('website_contact', ['_fragment' => 'form', 'success' => true]);
        }

        return $this->render('website/contact/send-message.html.twig', [
            'form' => $form->createView(),
            'success' => (bool) $request->get('success')
        ]);
    }
}
