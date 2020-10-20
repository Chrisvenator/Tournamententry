<?php

namespace App\Controller;

use App\Entity\TournamentEntry2;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TournamentEntry2Controller extends AbstractController {
    /**
     * @Route("/tournament/entry2", name="tournament_entry2")
     */
    public function createProduct(): Response {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $tounament = new TournamentEntry2();
        $tounament->setTraveldistance(100);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($tounament);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $entityManager->getId());
    }

}
