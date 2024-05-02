<?php

namespace App\Controller;

use App\Repository\BienImmobilierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\Clock\now;
use App\Entity\Annonce;

class CreateAnnonceController extends AbstractController
{
    #[Route('/createAnnonce', name: 'app_create_annonce')]
    public function index(BienImmobilierRepository $bienImmobilierRepository): Response
    {

        $annonce = new Annonce();
        $annonce->setTitre('Villa bord du lac d\'Annecy');
        $annonce->setDate(new \DateTime('now'));
        $annonce->setPrixM2Habitable('5000');
        $annonce->setBienImmobilier($bienImmobilierRepository->find(1));

        return $this->render('create_annonce/index.html.twig', [
            'controller_name' => 'CreateAnnonceController',
            'annonce' => $annonce,
        ]);
    }
}
