<?php

namespace App\Controller\Admin;

use App\Entity\Cadeau;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CadeauCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cadeau::class;
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
