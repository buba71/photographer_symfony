<?php

namespace App\Services;


class EmailerContact
{
   private $mailer;


   public function __construct(\Swift_Mailer $mailer)
   {
       $this->mailer =$mailer;
   }

   public function contactEmail(array $contactInfo)
   {


        list('name'=>$name, 'firstName'=>$firstName, 'email'=>$mail, 'message'=>$message) = $contactInfo;

        $newMessage = (new \Swift_Message('Nouveau Contact'))
            ->setFrom($mail)
            ->setTo('davdelima71@gmail.com')
            ->setBody($message);

        $this->mailer->send($newMessage);
   }
}