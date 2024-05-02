<?php

namespace App\Controller;

use App\Entity\BienImmobilier;
use App\Entity\Piece;
use App\Repository\BienImmobilierRepository;
use App\Repository\PieceRepository;
use App\Repository\TypePieceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;
use SecurityLib;
use RandomLib;
use App\Entity\User;

class DataImportController extends AbstractController
{
    #[Route('/dataImport', name: 'app_data_import')]
    public function index(UserRepository $userRepository, BienImmobilierRepository $bienImmobilierRepository, PieceRepository $pieceRepository, TypePieceRepository $typePieceRepository, EntityManagerInterface $entityManager): Response
    {

        // Créer les utilisateurs

        $userjson = file_get_contents('./users.json');
        $allUsers = json_decode($userjson, true);

        $factory = new RandomLib\Factory;
        $createdUsers = [];
        foreach ($allUsers as $user) {
            $newUser = $userRepository->findOneBy(['email' => $user['email']]);
            if (!$newUser) {
                $newUser = new User();
                $newUser->setEmail($user['email']);
                $newUser->setNom($user['nom']);
                $newUser->setTel($user['tel']);
                $newUser->setCarteAgentImmo($user['carteAgentImmo']);
                $generator = $factory->getMediumStrengthGenerator();
                $newUser->setPassword($generator->generateString(10));
                $entityManager->persist($newUser);
                $entityManager->flush();
                $createdUsers[$newUser->getNom()] = $newUser->getPassword();
                $createdUsers[$newUser->getNom()] = $newUser->getPassword();
            } else {
                $thisUser = $userRepository->findOneBy(['email' => $user['email']]);
                $createdUsers[$thisUser->getNom()] = $thisUser->getPassword() ;
            }
        }

        // Créer les Biens Immobiliers

        $biensimmojson = file_get_contents('./biensimmo.json');
        $allBiensImmo = json_decode($biensimmojson, true);

        foreach ($allBiensImmo as $bienImmo) {
            $newBienImmo = $bienImmobilierRepository->find($bienImmo['id']);
            if (!$newBienImmo) {
                $newBienImmo = new BienImmobilier();
                $newBienImmo->setRue($bienImmo['rue']);
                $newBienImmo->setVille($bienImmo['ville']);
                $newBienImmo->setCodePostal($bienImmo['code_postal']);
                $newBienImmo->setUser($userRepository->find($bienImmo['user_id']));
                $entityManager->persist($newBienImmo);
                $entityManager->flush();
            }
        }

        // Créer les pièces

        $piecesjson = file_get_contents('./pieces.json');
        $allPieces = json_decode($piecesjson, true);

        foreach ($allPieces as $piece) {
            $newPiece = $pieceRepository->find($piece['id']);
            if (!$newPiece) {
                $newPiece = new Piece();
                $newPiece->setSurface($piece['surface']);
                $newPiece->setBienImmobilier($bienImmobilierRepository->find($piece['bien_immobilier_id']));
                $newPiece->setTypePiece($typePieceRepository->find($piece['type_piece_id']));
                $entityManager->persist($newPiece);
                $entityManager->flush();
            }
        }

        return $this->render('data_import/index.html.twig', [
            'controller_name' => 'DataImportController',
            'createdUsers' => $createdUsers
        ]);
    }
}
