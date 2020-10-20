<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SayHelloContoller extends AbstractController {
    /**
     * @Route("/sayhello")
     */
    public function number() {
        $customerName = 'Stachelfisch';

        return $this->render('sayhello/greeting.html.twig', [
            'greeting' => $customerName
        ]);
    }
}