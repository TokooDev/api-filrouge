<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\LivrablePartiel;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\LivrableRepository;
use App\Repository\ApprenantRepository;
use App\Repository\DiscussionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use App\Repository\ReferentielRepository;
use App\Repository\LivrablePartielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\LivrablePartielDunApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\DiscussionLivrablePartielDunApprenantRepository;

class LivrablePartielController extends AbstractController
{
/**
 * @Route(
 * name="get_apprenants",
 * path="api/formateurs/promo/{id}/referentiel/{idr}/competences",
 * methods={"GET"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::showApprenantCollection",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="get_apprenants"
 * }
 * )
 */ 
public function showApprenantCollection(LivrablePartielRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id,int $idr)
{
    $apprenant =$apprenant -> findAll();
    if(empty($apprenant)){
       return new JsonResponse("cet apprenant n'existe pas", Response::HTTP_NOT_FOUND, [], true);
    }
    $promo =$promo -> find($id);
    
    $referentiel=$referentiel ->find($idr);
    if (empty($referentiel) || !$promo ->getReferentiel()->contains($referentiel)){
        return new JsonResponse("ce referentiel n'existe pas", Response::HTTP_NOT_FOUND, [], true);
    }
    if(empty($promo)){
        return new JsonResponse("cette promo n'existe pas", Response::HTTP_NOT_FOUND, [], true);
    }
    foreach($apprenant as $value){
        if($promo ->getApprenants()->contains($value) && $referentiel->getApprenants()->contains($value)) {
            $tabaprrenant[]=$value;
        }
  
    }
    $promojson = $serializer->serialize($tabaprrenant, 'json',["groups"=>["collectionApprenant:read"]]);
 
        return new JsonResponse($promojson, Response::HTTP_OK, [], true);
}

/**
 * @Route(
 * name="statistiques",
 * path="api/formateurs/promo/{id_promo}/referentiel/{id_ref}/statistiques/competences",
 * methods={"GET"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::statistiques",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="statistiques"
 * }
 * )
 */ 
public function statistiques(LivrablePartielRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id_promo,int $id_ref)
{
    $promo =$promo -> find($id_promo);
    if(empty($promo)){
        return new JsonResponse("cette promo n'existe pas", Response::HTTP_NOT_FOUND, [], true);
        
     }
     $referentiel=$referentiel ->find($id_ref);
     if (empty($referentiel) || !$promo ->getReferentiel()->contains($referentiel)){
         return new JsonResponse("ce referentiel n'existe pas", Response::HTTP_NOT_FOUND, [], true);
     }
     $promojson = $serializer->serialize($referentiel, 'json',["groups"=>["stats:read"]]);
 
        return new JsonResponse($promojson, Response::HTTP_OK, [], true);
}

/**
 * @Route(
 * name="get_apprenant",
 * path="api/apprenant/{id}/promo/{id_promo}/referentiel/{id_ref}/competences",
 * methods={"GET"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::showApprenantCollection",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="get_apprenant"
 * }
 * )
 */ 
public function showApprenant(LivrablePartielRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id,int $id_promo,int $id_ref)
{
    $apprenant =$apprenant -> find($id);
    if(empty($apprenant)){
       return new JsonResponse("cet apprenant n'existe pas", Response::HTTP_NOT_FOUND, [], true);
    }
    $promo =$promo -> find($id_promo);
    
    $referentiel=$referentiel ->find($id_ref);
    if (empty($referentiel) || !$promo ->getReferentiel()->contains($referentiel)){
        return new JsonResponse("ce referentiel n'existe pas", Response::HTTP_NOT_FOUND, [], true);
    }
    if(empty($promo)){
        return new JsonResponse("cette promo n'existe pas", Response::HTTP_NOT_FOUND, [], true);
    
    }
    if($promo ->getApprenants()->contains($apprenant) && $referentiel->getApprenants()->contains($apprenant)) {
        $resapp=$apprenant;
    }
    $promojson = $serializer->serialize($resapp, 'json',["groups"=>["Apprenant:read"]]);
 
        return new JsonResponse($promojson, Response::HTTP_OK, [], true);
}
/**
 * @Route(
 * name="brief_apprenant",
 * path="api/apprenants/{id/}promo/{id_promo}/referentiel/{id_ref}/statistiques/briefs",
 * methods={"GET"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::Apprenantbrief",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="brief_apprenant"
 * }
 * )
 */ 
public function Apprenantbrief(LivrablePartielRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id,int $id_promo,int $id_ref)
{
   
}

/**
 * @Route(
 * name="commentaires_livrablePartiel",
 * path="api/formateurs/livrablepartiels/{id}/commentaires",
 * methods={"GET"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::commentairesLivrablePartiel",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="commentaires_livrablePartiel"
 * }
 * )
 */ 

public function commentairesLivrablePartiel(CommentaireRepository $commentaire,DiscussionRepository $discussion,DiscussionLivrablePartielDunApprenantRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id)
{
    $livrablepartiel =$livrablepartiel -> find($id);
    if(empty($livrablepartiel)){
        return new JsonResponse("cette livrablepartiel n'existe pas", Response::HTTP_NOT_FOUND, [], true);
        
     }
     $disc=$livrablepartiel->getDiscussion();
     $promojson = $serializer->serialize($disc, 'json',["groups"=>["commentaires:read"]]);
 
        return new JsonResponse($promojson, Response::HTTP_OK, [], true);
}

/**
 * @Route(
 * name="commentaires_livrablePartiel_post",
 * path="api/formateurs/livrablepartiels/{id}/commentaires",
 * methods={"POST"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::commentairesLivrablePartielPost",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="commentaires_livrablePartiel_post"
 * }
 * )
 */ 

public function commentairesLivrablePartielPost(Request $request,EntityManagerInterface $manager,CommentaireRepository $commentaire,DiscussionRepository $discussion,DiscussionLivrablePartielDunApprenantRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id)
{

   $livrablepartiel =$livrablepartiel -> find($id);
   if(empty($livrablepartiel)){
        return new JsonResponse("cette livrablepartiel n'existe pas", Response::HTTP_NOT_FOUND, [], true);
        
    }

    
    $disc=$livrablepartiel->getDiscussion();
    $comm= new Commentaire();
    $comm->setDiscussion($disc);
    //dd($request->getContent());
    $comm->setContenu($request->getContent());
    $comm->setHeur(new\DateTime());
    
    /*$apprenant=$livrablepartiel->getLivrablePartielDunApprenant()->getApprenant();
    $comm->setA($formateur);*/
    $file=$request->files;
    if($file->get('fichier')!== null){
        $comm->setFichier($this->uploadFile($file->get('fichier'),"Fichier"));
    }

    $manager->persist($comm);
        $manager->flush();
  

     //$promojson = $serializer->serialize($comm, 'json');
 
        return new JsonResponse("Created", Response::HTTP_OK, [], true);
}

/**
 * @Route(
 * name="ajout_livrablePartiel",
 * path="api/formateurs/promo/{id_promo}/brief/{id_br}/livrablepartiels",
 * methods={"POST"},
 * defaults={
 * "_controller"="\app\ControllerLivrablePartielController::ajoutLivrablePartiel",
 * "_api_resource_class"=LivrablePartiel::class,
 * "_api_collection_operation_name"="ajout_livrablePartiel"
 * }
 * )
 */ 

public function ajoutLivrablePartiel(GroupeRepository $repogroupe,Request $request,EntityManagerInterface $manager,CommentaireRepository $commentaire,DiscussionRepository $discussion,DiscussionLivrablePartielDunApprenantRepository $livrablepartiel,ApprenantRepository $apprenant,PromoRepository $promo, SerializerInterface $serializer,ReferentielRepository $referentiel,int $id_promo,int $id_br)
{
    //$data=$request->getContent();
    $data = json_decode($request->getContent(), true);
    $livrablepartiel=$serializer->denormalize($data,LivrablePartiel::class, true,["groups"=>["livrablepartiel:write"]]);
   /*dd($livrablepartiel);
    if (isset($data['apprenants'])){
        
        $apprenants=$livrablepartiel['apprenants'];
        dd($apprenants);
        
    }
    if (isset($data['groupes'])){
        
        $groupes=$data['groupes'];
        
    }*/
    
    //$livrablepartiel=setDateDeLivraison(new \DateTime());
    $manager->persist($livrablepartiel);
    $manager->flush();
        
        return new JsonResponse("Created", Response::HTTP_OK, [], true);
}
}
