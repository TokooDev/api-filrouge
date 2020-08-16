<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApprenantController extends AbstractController
{
    /**
     * @Route(
     * name="apprenantsList",
     * path="api/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\ControllerApprenantController::showApprenant",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="getApprenants"
     * }
     * )
     */
    public function showApprenant(UserRepository $repo)
    {
        $apprenants= $repo->findByProfil("Apprenant");
        return $this->json($apprenants,Response::HTTP_OK,);

    }
}
