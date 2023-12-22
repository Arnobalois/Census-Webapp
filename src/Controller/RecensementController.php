<?php

namespace App\Controller;
use \Doctrine\Common\Util\Debug;
use App\Repository\HabitantRepository;
use App\Repository\HabitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Habitant;
use App\Entity\Habitation;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\HabitantType;
use App\Form\ModificationType;
use App\Form\AjoutType;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
use Symfony\Component\HttpFoundation\Request;

class RecensementController extends AbstractController
{
    #[Route('/', name: 'app_recensement')]
    public function index(): Response
    {
        
        return $this->render('recensement/index.html.twig', [
            'controller_name' => 'RecensementController',
        ]);
    }

    #[Route('/ListHabitant', name: 'app_recensement_affichage')]
    public function AffichageHabitant(HabitantRepository $habitantRepository,HabitationRepository $habitationRepository): Response
    {
        $habitants = $habitantRepository->findAll();
        return $this->render('recensement/affichage.html.twig', [
            'controller_name' => 'RecensementController',
            'habitants'=>$habitants,
        ]); ;
    }
    
    #[Route('/Add_User', name: 'app_recensement_add')]
    public function add(Request $request,EntityManagerInterface $em,HabitationRepository $habitationRepository): Response
    {
        $habitations = $habitationRepository->findAll();
        $habitant = new Habitant();
        $form = $this->createForm(HabitantType::class, $habitant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $persist = false ;
            $currentHabitation = $form->get("habitation")->getData();
            $habitant = $form->getData();
            $currentHabitationAdresse = strtolower(preg_replace('/\s+/', '', $currentHabitation->getAdresse()));
            foreach( $habitations as $habitation ) {
                $adresse = preg_replace('/\s+/', '', $habitation->getAdresse());

                if(strtolower($adresse) == $currentHabitationAdresse ){
                    $habitation->addHabitant($habitant);
                    $em->persist($habitation);
                    $persist = true ;
                    break;
                }
            }
            if(!$persist){
                $currentHabitation->addHabitant($habitant);
                $em->persist($currentHabitation);
            }
            $em->flush();

            return $this->redirect('/ListHabitant');
        }
        return $this->render('recensement/Ajout.html.twig', [
            'controller_name' => 'RecensementController',
            'form' => $form,            
        ]); ;
    }

    #[Route('/Modify_User/{id}', name: 'app_recensement_modify')]
    public function modify(Request $request,Habitant $habitant,EntityManagerInterface $em,HabitationRepository $habitationRepository): Response
    {
        $habitations = $habitationRepository->findAll();
        $oldAdresse = $habitant->getHabitation()->getAdresse();
        dump($habitations);
        $form = $this->createForm(HabitantType::class, $habitant);
        $form->handleRequest($request);
        dump($habitations);
        $found = false ;
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            dump($habitations);
            $currentHabitation = $habitant->getHabitation();
            $currentHabitation->removeHabitant($habitant);
            $newHabitationAdresse = $currentHabitation->getAdresse();
            $currentHabitation->setAdresse($oldAdresse);
            $newHabitationAdresseLowered =  strtolower(preg_replace('/\s+/', '', $newHabitationAdresse));
            foreach( $habitations as $habitation ) {
                $adresse = strtolower(preg_replace('/\s+/', '', $habitation->getAdresse()));
                dump($adresse);
                dump($newHabitationAdresseLowered);
                if ( $adresse == $newHabitationAdresseLowered){
                    dump("Une adresse identique trouvé");
                    dump($habitation->getId());
                    $habitation->addHabitant($habitant);
                    $em->persist($habitation);
                $found = true ;
                break;
                }
            }
            if(!$found){
                dump("Creation nouvelle adresse");
                $newHabitation = new Habitation();
                $newHabitation->setAdresse($newHabitationAdresse);
                $newHabitation->addHabitant($habitant);
                $em->persist($newHabitation);
            }
            
            dump($habitant);
        $em->flush();

            return $this->redirect('/ListHabitant');
        }

        return $this->render('recensement/modification.html.twig', [
            'controller_name' => 'RecensementController',
            'form' => $form,
        ]); ;
    }

    #[Route('/Delete_User/{id}', name: 'app_recensement_delete')]
    public function delete(Habitant $habitant,EntityManagerInterface $em): Response
    {
      $em->remove($habitant);
      $em->flush();
        return $this->redirect('/ListHabitant');
    }

    #[Route('/Rechercher', name: 'app_recensement_rechercher')]
    public function RechercheHabitant(Request $request): Response
    {
        return $this->render('recensement/recherche.html.twig', [
            'controller_name' => 'RecensementController',
        ]);
    }
    #[Route('/ListHabitantApi', name: 'app_recensement_affichage_api')]
    public function AffichageHabitantApi(HabitantRepository $habitantRepository,HabitationRepository $habitationRepository): Response
    {

        $habitants = $habitantRepository->findAllArray();
        
        return new JsonResponse($habitants);
    }
}
