<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use ReCaptcha\ReCaptcha;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Swift;


class ContactController extends AbstractController
{
    /**
     * @var \Swift Mailer
     */
    private $mailer;
    

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }


    /**
    * @Route("/contact", name="contact_us")
    */
    public function index(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        
    
        $form->handleRequest($request);

      /* captcha */
        
      $recaptcha = new ReCaptcha('6LdDO7wUAAAAAKqDqlV9jGYnaJv2_NRKRgaFVmEa');
      $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

    
            if($form->isSubmitted() && $form->isValid()) {
                if (!$resp->isSuccess()) {
                    $this->addFlash('success','N\'oubliez pas de cocher la case "Je ne suis pas un robot"');
                  } else {

                $message = (new \Swift_Message($contact))
                ->setFrom('infos@avenuedesartistes.com')
                ->setTo('polvu@hotmail.fr')
                ->setSubject($contact->getSubject())
                ->setReplyTo($contact->getEmail())
                ->setBody($contact->getMessage(),'text/html')
            ;
            
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            $this->mailer->send($message);
                
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);   
        
                }
      
}