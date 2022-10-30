<?php

namespace App\Controller\Admin;

use App\Entity\GolfClub;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GolfClubCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GolfClub::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
