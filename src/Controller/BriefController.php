<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Repository\BriefRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/formateurs/promos/{idP}/groupes/{idG}/briefs",
     *     name="getBriefsOfGroupeOfPromo",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::showbriefofgroupeofpromo",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="getBriefsOfGroupeOfPromo"
     *     }
     * )
     */
    public function showbriefofgroupeofpromo(int  $idP,int $idG,BriefRepository $repo, SerializerInterface $serializer)
    {
        $briefs = $repo->findBriefsByPromoAndGroupe($idP, $idG);
        $briefsjson = $serializer->serialize($briefs, 'json', ['groups'=>["briefsofgroupeofpromo:read"]]);
        return new JsonResponse($briefsjson, Response::HTTP_OK, [], true);
    }



    /**
     * @Route(
     *     path="/api/formateurs/{id}/briefs/brouillons",
     *     name="getBriefsBrouillonsOfFormateur",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::showbriefsbrouillonofformateur",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="getBriefsBrouillonsOfFormateur"
     *     }
     * )
     */
    public function showbriefsbrouillonofformateur(int  $id,BriefRepository $repo, SerializerInterface $serializer)
    {
        $briefs = $repo->findBriefsBrouillonsOfFormateur($id);
        $briefsjson = $serializer->serialize($briefs, 'json', ['groups'=>["briefsbrouillonofformateur:read"]]);
        return new JsonResponse($briefsjson, Response::HTTP_OK, [], true);
    }
}


