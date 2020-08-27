<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivrablePartielDunApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivrablePartielDunApprenantController extends AbstractController
{
/**
 * @Route(
 * name="",
 * path="formateurs/promo/{id}/referentiel/{idd}/competences",
 * methods={"GET"},
 * defaults={
 * "_controller"="\app\ControllerApprenantController::showApprenantCollection",
 * "_api_resource_class"=LivrablePartielDunApprenant::class,
 * "_api_collection_operation_name"=""
 * }
 * )
 */
    public function showApprenantCollection(LivrablePartielDunApprenantRepository $repo)
    {
       $collection = $repo->findAll();
       return $this->json($collection,Response::HTTP_OK,);
    }
}
