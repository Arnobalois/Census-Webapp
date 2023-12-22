<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\HabitantRepository;
use App\Repository\HabitationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Habitant;
use App\Entity\Habitation;
use Doctrine\ORM\EntityManagerInterface;

class RecensementApiController extends AbstractController
{
    #[Route('/api/list_habitants', name: 'app_recensement_affichage_api')]
    public function AffichageHabitantApi(HabitantRepository $habitantRepository,HabitationRepository $habitationRepository): Response
    {

        $habitants = $habitantRepository->findAllArray();
        
        return new JsonResponse($habitants);
    }
    #[Route('/api/delete_user/{id}', name: 'app_recensement_delete')]
    public function delete(Habitant $habitant = null, EntityManagerInterface $em): Response
    {
        // Check if the Habitant with the specified ID exists
        if ($habitant === null) {
            return new JsonResponse(['error' => 'Habitant not found'], 404);
        }

        // Remove and flush if the Habitant exists
        $em->remove($habitant);
        $em->flush();

        return new JsonResponse(['sucess' => 'Habitant was successfully removed'], 200);
    }

    #[Route('/api/list_habitations', name: 'app_recensement_habitation_api')]
    public function ApiHabitationsList(HabitationRepository $habitationRepository): Response
    {

        $habitants = $habitationRepository->getAllHomes();
        
        return new JsonResponse($habitants);
    }

    #[Route('/api/habitants_at_habitat/{id}', name: 'app_recensement_habitants_at_habitat_api')]
    public function ApiHabitantsAtHabitat(Habitation $habitation = null,HabitationRepository $habitantRepository): Response
    {
        // Check if the Habitant with the specified ID exists
        if ($habitation === null) {
            return new JsonResponse(['error' => 'Habitation not found'], 404);
        }
        $id_habitat = $habitation->getId();
        $habitants = $habitantRepository->getHabitantsForHabitat($id_habitat);
        
        return new JsonResponse($habitants);
    }
}

//
