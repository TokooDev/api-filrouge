<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\FormateurRepository;
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
     * @Route("/api/formateurs/{id}/briefs/brouillons", name="showBriefsBrouillonsOfformateur", methods="GET")
     */
    public function getBriefBroullonOfFormateur(SerializerInterface $serializer, int $id, PromoRepository $repoPromo, FormateurRepository $repoFormateur, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {

        $formateur = $repoFormateur->find($id);
        if (empty($formateur)) {
            return new JsonResponse("Ce formateur n'existe pas dans le système.", Response::HTTP_NOT_FOUND, [], true);
        }

        foreach ($formateur->getBriefs() as $value) {
            if ($value->getEtatBrief()->getLibelle() != "Brouillon") {
                $formateur->removeBrief($value);
            }
        }

        if (count($formateur->getBriefs()) < 1) {
            return new JsonResponse("Ce formateur n'a aucun brief en brouillon.", Response::HTTP_NOT_FOUND, [], true);
        }

        $briefJson = $serializer->serialize($formateur->getBriefs(), 'json', ["groups" => ["briefsbrouillonsofformateur:read"]]);
        return new JsonResponse($briefJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/formateurs/{id}/briefs/valide", name="showBriefsValideOfformateur", methods="GET")
     */
    public function getBriefValideOfFormateur(SerializerInterface $serializer, int $id, PromoRepository $repoPromo, FormateurRepository $repoFormateur, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {

        $formateur = $repoFormateur->find($id);
        if (empty($formateur)) {
            return new JsonResponse("Ce formateur n'existe pas dans le système.", Response::HTTP_NOT_FOUND, [], true);
        }

        foreach ($formateur->getBriefs() as $value) {
            if ($value->getEtatBrief()->getLibelle() != "Valide") {
                $formateur->removeBrief($value);
            }
        }

        if (count($formateur->getBriefs()) < 1) {
            return new JsonResponse("Ce formateur n'a aucun brief valide.", Response::HTTP_NOT_FOUND, [], true);
        }

        $briefJson = $serializer->serialize($formateur->getBriefs(), 'json', ["groups" => ["briefsvalidesofformateur:read"]]);
        return new JsonResponse($briefJson, Response::HTTP_OK, [], true);
    }
}


