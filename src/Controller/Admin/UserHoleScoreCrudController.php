<?php

namespace App\Controller\Admin;

use App\Entity\UserHoleScore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserHoleScoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserHoleScore::class;
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
