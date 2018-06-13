<?php

namespace AppBundle\Controller\Website;

use AppBundle\DependencyInjection\Mail\MailContact;
use AppBundle\Entity\PageStatic;
use AppBundle\Form\Type\MessageType;
use AppBundle\Manager\MessageManager;
use AppBundle\Manager\PageStaticManager;
use AppBundle\Manager\ZoneManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /** @var PageStaticManager */
    private $pageStaticManager;

    public function __construct(PageStaticManager $pageStaticManager)
    {
        $this->pageStaticManager = $pageStaticManager;
    }

    /**
     * @Route("/contact", name="website_contact")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param MessageManager $messageManager
     * @param MailContact $mailContact
     * @param ZoneManager $zoneManager
     * @return RedirectResponse|Response
     */
    public function sendMessageAction(
        Request $request,
        MessageManager $messageManager,
        MailContact $mailContact,
        ZoneManager $zoneManager
    ): Response
    {
        /** @var $pageStatic PageStatic */
        $pageStatic = $this->pageStaticManager->get(PageStatic::PAGE_CONTACT);

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
            'success' => (bool)$request->get('success'),
            'zones' => $zoneManager->getList(),
            'pageStatic' => $pageStatic,
        ]);
    }
}
