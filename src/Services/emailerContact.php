<?php

namespace App\Services;

use Twig\Environment;


class emailerContact
{

    private $mailer;
    private $twig;

    /**
     * EmailerContact constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer =$mailer;
        $this->twig = $twig;
    }

    /**
     * @param array $contactInfo
     * @ service that send an email to admin from any user
     */
    public function contactEmail(array $contactInfo):void
    {
        list('name'=>$name, 'firstName'=>$firstName, 'email'=>$mail, 'message'=>$message) = $contactInfo;

        $newMessage = (new \Swift_Message('Nouveau Contact'))
            ->setFrom($mail)
            ->setTo('d.delima@outlook.fr')
            ->setSubject('Nouveau contact')

            ->setBody($this->twig->render('contact/mailing.html.twig', array(
                'contactName'      => $name,
                'contactFirstName' => $firstName,
                'contactEmail'     => $mail,
                'contactMessage'   => $message
            )), 'text/html');

        $this->mailer->send($newMessage);
    }
}