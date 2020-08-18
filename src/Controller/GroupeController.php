<?php

namespace App\Controller;

use App\Entity\Groupe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeController extends AbstractController
{
    /**
     * @Route(
     * name="archiveGroupe",
     * path="api/admin/groupes/{id}/archive",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\app\Controller\GroupeController::archiveGroupe",
     * "_api_resource_class"=Groupe::class,
     * "_api_item_operation_name"="archiveGroupe"
     * }
     * )
     */
    public function archiveGroupe(Request $request,EntityManagerInterface $manager)
    {
        $groupe=new Groupe();
        $groupe->setArchived(1);
        $manager->persist($groupe);
        $manager->flush();
    }
}
