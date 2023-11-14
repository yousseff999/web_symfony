<?php

namespace App\Controller;

use App\Entity\Reponse;
use Doctrine\ORM\EntityNotFoundException;
use App\Form\ReclamationType;
use App\Form\ReponseType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'app_reponse')]
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }

    #[Route('/listReclamation', name: 'list_reclamationDB')]
    public function listReclamation(ReclamationRepository $reclamationrepository): Response
    {
        
        return $this->render('reponse/listReclamation.html.twig', [
            'reclamations' => $reclamationrepository->findAll(),
        ]);
    }

    #[Route('/reclamation/delete/{id}', name: 'reclamation_delete')]
    public function deleteReclamation($id, ManagerRegistry $manager, ReclamationRepository $reclamationrepository): Response
    {
        $em = $manager->getManager();
        $reclamation = $reclamationrepository->find($id);
       
            $em->remove($reclamation);
            $em->flush();
        
        return $this->redirectToRoute('list_reclamationDB');
    }
//hnshngsgnhnwnshvwhns
    #[Route('/reclamation/edit/{id}', name: 'reclamation_edit')]
    public function editReclamation(Request $request, ManagerRegistry $manager, $id, ReponseRepository $reponserepository): Response
    {
        $em = $manager->getManager();

        $Reponse = new Reponse();

        $form = $this->createForm(ReponseType::class, $Reponse);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($Reponse);
            $em->flush();
            
            $this->addFlash('success', 'Reponse added successfully!');

            return $this->redirectToRoute('list_reclamationDB');
        }
        //dump('Template rendered!');
        return $this->renderForm('reponse/editReclamation.html.twig', ['form' => $form]);
    }
    
    
    
}


