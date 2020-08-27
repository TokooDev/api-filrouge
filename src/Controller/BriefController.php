<?php

namespace App\Controller;

use App\Entity\CM;
use App\Entity\User;
use App\Entity\Brief;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\BriefMaPromo;
use App\Entity\BriefApprenant;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BriefMaPromoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
    /**
     *  @Route(
     * path="/api/formateurs/promo/{id_promo}/briefs/{id_brief}/assignation", 
     * methods={"PUT"}
     * )
     */
    public function assignerBrief($id_promo, $id_brief,EntityManagerInterface $em, ApprenantRepository $apprenantRepository, BriefRepository $briefRepository,PromoRepository $promoRepository,GroupeRepository $groupeRepository, BriefMaPromoRepository $briefMaPromoRepository,Request $request, SerializerInterface $serializer)
    {
        if (!$id_promo || !$id_brief) {
            return $this->json(["message"=>"la demande n'a pas été trouvée"],
        Response::HTTP_NOT_FOUND);
        } 
        //verifie si promo et brief existe 
        $brief=$briefRepository->findOneById($id_brief);
        $promo=$promoRepository->findOneById($id_promo);
        if (!$id_brief || !$id_promo)
        {
            return $this->json(["message"=>"la demande n'a pas été trouvée"],
        Response::HTTP_NOT_FOUND);
        }
        //verifie si le brief est dans le promo
        
        $briefMaPromo=$briefMaPromoRepository->findOneBy(['briefs'=>$brief, 'promos'=>$promo]);
        if(!$briefMaPromo)
        {
             return $this->json(["message"=>"la demande n'a pas été trouvée"],
        Response::HTTP_NOT_FOUND);


        }
        if(!empty($request->getContent()))
        {
            $data=$request->getContent();
        }
        else{
            $data=$request->request->all();

        }
        
        $data=$serializer->decode($data, "json");
        //dd($briefMaPromo);
        //dd($data);
        //affectation
        if(!empty($data['action']) && $data['action'] == "affecter")
        {    
            //dd($data['action']);
            //affecter le brief a un promo
            if (!empty($data['apprenant_id']))
            {
               ($data['apprenant_id']);
              
              
               $briefApprenant=new BriefApprenant();
               $apprenant=$apprenantRepository->findOneById($data['apprenant_id']);
               dd($apprenant);
               $statut=$data['statut']?? "livrer";
               $briefApprenant->setStatut($statut);
               $briefApprenant->addApprenant($apprenant);
               $briefApprenant->addBriefmaPromo($briefMaPromo);
               $em->persist($briefMaPromo);
               $em->flush();
              
            }
            elseif (!empty($data['groupe_id']))
            {
                //affecter un brief a un groupe
                $briefMaPromo=new BriefMaPromo();
                $groupe=$groupeRepository->findOneBy($data['groupe_id']);
                $brief->addGroupe($groupe);
                //ajoute la promo de ce groupe dnas le brief
                $promoGroupe= $groupe->getPromo();
                $nomGroupe=$groupe->getNom();
                if (!empty($promoGroupe) && $nomGroupe!= 'GroupePrincipal')
                {
                    $briefPromo=new BriefMaPromo();
                    $briefPromo->setBriefs($brief);
                    $briefPromo->setPromos($promoGroupe);
                    $em->persist($briefPromo);
                    $em->flush();
                    
                }
                $em->flush();

               
            }else{
                    return $this->json(["message"=>"affecter un brief a un apprenant ou a un groupe "],
                Response::HTTP_NOT_FOUND);
            }


        }elseif (!empty($data['action']) && $data['action'] == "desaffecter")
        {
            //desaffecter le brief a un apprenant 
            if(!empty($data['apprenant_id']))
            {
                $apprenant=$apprenantRepository->findOneById($data['apprenant_id']);
                $briefMaPromoDel= $briefMaPromoRepository->find(['briefApprenant'=>
                $apprenant, 'promos' => $promo]);
                $em->remove($briefMaPromoDel);


            }
            elseif (!empty($data['groupe_id']))
            {
               //affecter le brief a un groupe
               $groupe=$groupeRepository->findOneById($data['groupe_id']);
               $brief->removeGroupe($groupe);
               //ajout la promo dans le brief
               $em->flush();
            }else{
                   return $this->json(["message"=>"desacffecter un brief a un apprenant ou a un groupe "],
                Response::HTTP_NOT_FOUND);

            }

            
        }else{
                    return $this->json(["message"=>"la demande n'a pas été trouvée "],
                Response::HTTP_NOT_FOUND);
        }
            
        

        

       

    }
    /**
     *path="/formateurs/promo/{id_promo}/briefs/{id_brief}", 
     * methods={"PUT"}
     */

    public function updateBrief(SerializerInterface $serializer, PromoRepository $promoRepository,BriefRepository $briefRepository,Request $request,BriefMaPromoRepository $briefMaPromoRepository, $id_promo,$id_brief)
    {
        //cette methode modifie un brief
        if(!$id_promo || $id_brief)
        {
            return $this->json(["message"=>"la demande n'a pas été trouvée"],
        Response::HTTP_NOT_FOUND);
        }
        //verifie si promo et brief existe
        $brief=$briefRepository->findOneById($id_brief);
        $promo=$promoRepository->findOneById($id_promo);
        if (!$id_brief || !$id_promo)
        {
            return $this->json(["message"=>"la demande n'a pas été trouvée"],
        Response::HTTP_NOT_FOUND);
        }
        //verifie si brief est dans le promo
        $resultbriefInPromo=$briefMaPromoRepository->findBy(['briefs'=> $brief, 'promos'=>$promo]);
        if ($resultbriefInPromo)
        {
            return $this->json(["message"=>"la demande n'a pas été trouvée"],
        Response::HTTP_NOT_FOUND);
            
        }
        if(!empty($request->getContent()))
        {
            $data=$request->getContent();
        }
        else{
            $data=$request->request->all();

        }
        $data=$serializer->decode($data, "json");
        //verifie si la valeur existe on fait setter sinon on ne fait rien
        if(!empty($adata['langue']))
        {
            $brief->setLangue($data['langue']);
        }
        if(!empty($adata['titre']))
        {
            $brief->setTitre($data['titre']);
        }
        if(!empty($adata['contexte']))
        {
            $brief->setContexte($data['contexte']);
        }
        if(!empty($adata['modalitePedagogique']))
        {
            $brief->setModalitePedagogique($data['modalitePedagogique']);
        }
        if(!empty($adata['critersPerformance']))
        {
            $brief->setCritersPerformance($data['critersPerformance']);
        }
        if(!empty($adata['etat']))
        {
            $brief->setEtat($data['etat']);
        }
        if(!empty($adata['description']))
        {
            $brief->setDescription($data['description']);
        }
        if(!empty($adata['modaliteDevaluation']))
        {
            $brief->setModaliteDevaluation($data['modaliteDevaluation']);
        }
        if(!empty($adata['archived']))
        {
            $brief->setArchived($data['archived']);
        }



    }
}
