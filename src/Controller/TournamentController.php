<?php

namespace App\Controller;

use App\Entity\TournamentEntry2;
use App\Form\TournamentType;
use Doctrine\DBAL\Types\IntegerType;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TournamentController extends AbstractController {
    /**
     * @Route("/tournament", name="tournament")
     */
    public function index() {
        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
        ]);
    }


    /**
     * @Route("/tournament/add", name="add_tournament")
     */
    public
    function addTournamentEntry(Request $request): Response {
        $tournamentEntry2 = new TournamentEntry2();
        $form = $this->createForm(TournamentType::class, $tournamentEntry2)
            ->add('traveldistance')
            ->add('model')
            ->add('flight_duration', TextType::class)
            ->add('participant_name', TextType::class)
            ->add('date', DateType::class)
            ->add('round', NumberType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Entry']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('results');
        }

        return $this->render('hew.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/results", name="results")
     */
    public
    function success() {
        $tournament = $this->getDoctrine()->getRepository(TournamentEntry2::class);
        return $this->render("success.html.twig", ["menus" => $tournament->findAll(), "round" => "All"]);
    }

    /**
     * @Route("/resultsRoot/{id}", name="rootRound")
     */
    public function Resultsroot(string $id) {
        if ($id == "passord") {
            $tournament = $this->getDoctrine()->getRepository(TournamentEntry2::class);
            return $this->render("adminSuccess.html.twig", ["menus" => $tournament->findAll(), "round" => "All"]);
        } else {
            return new Response("Passwort benötigt!");
        }
    }

    /**
     * @Route("/delete/{id}", name="delete_tournament")
     */
    public function delete(int $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $tournamentEntry2 = $this->getDoctrine()->getRepository(TournamentEntry2::class);

        $entry = $tournamentEntry2->find($id);
        $entityManager->remove($entry);
        $entityManager->flush();

        return $this->redirectToRoute('rootRound');
    }

    /**
     * @Route("/results/{id}", name="showRounds")
     */
    public function rounds(int $id) {
        $tournament = $this->getDoctrine()->getRepository(TournamentEntry2::class);
        return $this->render("success.html.twig", ["menus" => $tournament->findBy(['round' => $id]), "round" => $id]);
    }

    /**
     * @Route("/participants/{id}", name="showRound")
     */
    public function participants(string $id) {
        $tournament = $this->getDoctrine()->getRepository(TournamentEntry2::class);
        return $this->render("success.html.twig", ["menus" => $tournament->findBy(['participant_name' => $id]), "round" => $id]);
    }

    /**
     * @Route("/api/tournament.{_format}", format="html", requirements={ "_format": "html|json" })
     * @param Request $request
     * @return Response
     */
    public function API(Request $request, SerializerInterface $serializer): Response {
        if ($request->getRequestFormat() == 'json') {
            if ($request->getMethod() == 'GET') {
                $data = $this->getDoctrine()->getRepository(TournamentEntry2::class)->findAll();
                return new Response($serializer->serialize($data, 'json'));
            }
            if ($request->getMethod() == 'POST') {
                $data = json_decode($request->getContent(), true);

                $entityManager = $this->getDoctrine()->getManager();

                $TournamentEntry = new TournamentEntry2();
                $TournamentEntry->setDate(new \DateTime());
                $TournamentEntry->setFlightDuration($data["flightDuration"]);
                $TournamentEntry->setModel($data["model"]);
                $TournamentEntry->setParticipantName($data["ParticipantName"]);
                $TournamentEntry->setRound($data["Round"]);
                $TournamentEntry->setTraveldistance($data["TravelDistance"]);

                $entityManager->persist($TournamentEntry);

                $entityManager->flush();

            }
            if ($request->getMethod() == 'DELETE') {
                $data = json_decode($request->getContent(), true);

                $entityManager = $this->getDoctrine()->getManager();
                $tournamentEntry2 = $this->getDoctrine()->getRepository(TournamentEntry2::class);

                $entry = $tournamentEntry2->find($data["id"]);
                $entityManager->remove($entry);
                $entityManager->flush();
            }
        }
        return new Response("Yes");
    }
}