<?php

namespace App\Controller;

use App\Repository\HabitantRepository;
use App\Repository\HabitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Habitant;
use App\Entity\Habitation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;

class RecensementController extends AbstractController
{
    #[Route('/recensement', name: 'app_recensement')]
    public function index(): Response
    {
        return $this->render('recensement/index.html.twig', [
            'controller_name' => 'RecensementController',
        ]);
    }

    #[Route('/ListHabitant', name: 'app_recensement_affichage')]
    public function AffichageHabitant(HabitantRepository $habitantRepository): Response
    {
        $habitants = $habitantRepository->findAll();
        
        return $this->render('recensement/affichage.html.twig', [
            'controller_name' => 'RecensementController',
            'habitants'=>$habitants,
        ]); ;
    }
/* Ajout d'un jeu de test
    #[Route('/Add_User', name: 'app_recensement_add')]
    public function add(HabitationRepository $habitationRepository, EntityManagerInterface $em): Response
    {
        $habitation = new Habitation();
        $habitation->setVille("Saint Denis en Val")->setCodePostal("45560")->setNumeroDeVoie("6")->setRue("la bergoennerie")->setTypeVoie("rue")->setPays("France")->setComplement("Aucun");
        $habitant = new Habitant();
        $habitant->setNom("Balois")->setPrenom("Arno")->setGenre("Homme")->setDateDeNaissance(DateTime::createFromFormat('d/m/Y','09/01/2001'));
        $habitation->addHabitant($habitant);

        $em->persist($habitation);
        
        $em->flush();
        return $this->render('recensement/index.html.twig', [
            'controller_name' => 'RecensementController',
        ]);
    }
*/
    /*
    #[Route('/Add_User', name: 'app_recensement_add')]
    public function add(Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        return new JsonResponse ;
    }

    #[Route('/Modify_User', name: 'app_recensement_modify')]
    public function modify(Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);


        return new JsonResponse ;
    }

    #[Route('/Delete_User', name: 'app_recensement_delete')]
    public function delete(Request $request): Response
    {
        $data = $request->getContent();
        $data = json_decode($data, true);
        

        return new JsonResponse ;
    }*/
}
