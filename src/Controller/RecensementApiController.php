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
    public function delete(Habitant $habitant,EntityManagerInterface $em): Response
    {
      $em->remove($habitant);
      $em->flush();
        return new JsonResponse(200);
    }

    #[Route('/api/list_habitations', name: 'app_recensement_habitation_api')]
    public function ApiHabitationsList(HabitationRepository $habitationRepository): Response
    {

        $habitants = $habitationRepository->getAllHomes();
        
        return new JsonResponse($habitants);
    }
}

//
