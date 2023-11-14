<?php

namespace App\Controller;
use App\Form\ReclamationType;
use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
 
    #[Route('/addReclamation', name: 'add_reclamation')]
    public function addReclamation(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();

        $Reclamation = new Reclamation();

        $form = $this->createForm(ReclamationType::class, $Reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($Reclamation);
            $em->flush();
            
            $this->addFlash('success', 'Reclamation added successfully!');

            return $this->redirectToRoute('list_lastrec');
        }
        //dump('Template rendered!');
        return $this->renderForm('reclamation/addRec.html.twig', ['form' => $form]);
    }
    
    #[Route('/listLastRec', name: 'list_lastrec')]
    public function listReclamation(ReclamationRepository $reclamationRepository): Response
    {
        // Fetch the latest reclamation based on some condition, for example, the highest ID
        $latestReclamation = $reclamationRepository->findOneBy([], ['id' => 'DESC']);
        $successMessage = $this->get('session')->getFlashBag()->get('success') ?? ['Reclamation added successfully!'];

        dump($successMessage);

        return $this->render('reclamation/listLastRec.html.twig', [
            'latestReclamation' => $latestReclamation,
            'successMessage' => $successMessage,
        ]);
    }
    
}
