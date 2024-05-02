<?php

namespace App\Tests;

use App\Entity\BienImmobilier;
use App\Entity\Piece;
use PHPUnit\Framework\TestCase;
use App\Entity\TypePiece;

class CalculSurfaceHabitableTest extends TestCase
{
    public function testCalculSurfaceHabitableBienImmoFunctionnal(): void
    {

        $bienImmobilier = new BienImmobilier();
        $typePiece1 = new TypePiece();
        $typePiece2 = new TypePiece();
        $typePiece3 = new TypePiece();
        $piece1 = new Piece();
        $piece2 = new Piece();
        $piece3 = new Piece();

        $bienImmobilier->setRue('Rue de chez moi');
        $bienImmobilier->setVille('Paris');
        $bienImmobilier->setCodePostal('75000');

        $typePiece1->setSurfaceHabitable(true);
        $typePiece1->setLibelle('Chambre');
        $typePiece2->setSurfaceHabitable(true);
        $typePiece2->setLibelle('Cuisine');
        $typePiece3->setSurfaceHabitable(false);
        $typePiece3->setLibelle('Garage');

        $piece1->setSurface(100);
        $piece1->setTypePiece($typePiece1);
        $piece1->setBienImmobilier($bienImmobilier);

        $piece2->setSurface(50);
        $piece2->setTypePiece($typePiece2);
        $piece2->setBienImmobilier($bienImmobilier);

        $piece3->setSurface(100);
        $piece3->setTypePiece($typePiece3);
        $piece3->setBienImmobilier($bienImmobilier);

        $bienImmobilier->addPiece($piece1);
        $bienImmobilier->addPiece($piece2);
        $bienImmobilier->addPiece($piece3);

        $this->assertEquals(150, $bienImmobilier->SurfaceHabitable());

    }
}
