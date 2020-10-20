<?php

namespace App\Controller;

use App\Entity\TournamentEntry2;
use App\Form\TournamentType;
use Doctrine\DBAL\Types\IntegerType;
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
     * @Route(
     *     "/tournament/showLehrer/{id}.{_format}",
     *     format="html",
     *     name="show_tournamententry_json",
     *     requirements={
     *         "_format": "html|json|xml",
     *     }
     * )
     */
    public function showLehrer(TournamentEntry2 $tournamentEntry, string $_format, SerializerInterface $serializer): Response {
        if ($_format == 'json') {
            $jsonContent = $serializer->serialize($tournamentEntry, 'json');
            return new Response($jsonContent);
        }
        if ($_format == 'xml') {
            $xmlContent = $serializer->serialize($tournamentEntry, 'xml');
            return new Response($xmlContent);
        }
        return new Response('Easily found tournament entry with flying distance ' . $tournamentEntry->getTraveldistance());
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
     * @Route("/resultsRoot", name="rootRound")
     */
    public function Resultsroot() {
        $tournament = $this->getDoctrine()->getRepository(TournamentEntry2::class);
        return $this->render("adminSuccess.html.twig", ["menus" => $tournament->findAll(), "round" => "All"]);
    }

    /**
     * @Route("/deleteMEME/{id}", name="delete_tournament")
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
     * @Route("/results/{id}", name="showRound")
     */
    public
    function rounds(int $id) {
        $tournament = $this->getDoctrine()->getRepository(TournamentEntry2::class);
        return $this->render("success.html.twig", ["menus" => $tournament->findBy(['round' => $id]), "round" => $id]);
    }


    /**
     * @Route("/tournament/create/{traveldistance}", name="create_tournament")
     */
    public
    function createTournamentEntry(float $traveldistance, ValidatorInterface $validator): Response {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $tounamentEntry = new TournamentEntry2();
        $tounamentEntry->setTraveldistance($traveldistance);

//        $errors = $validator->validate($traveldistance);
//        if (count($errors) > 0) {
//            return new Response((string)$errors, 400);
//        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($tounamentEntry);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new Tournament Entry with id ' . $tounamentEntry->getId() . " and : " . $traveldistance . " meter");
    }

    /**
     * @Route("/tournament/show/{id}", name="show_tournament")
     */
    public
    function show(TournamentEntry2 $tournamentEntry2) {
        return new Response('Check out this great product: ' . $tournamentEntry2->getTraveldistance());
    }

}