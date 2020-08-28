<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livrable;
use App\Entity\Apprenant;
use Doctrine\ORM\EntityManager;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\LivrableAttendusApprenant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivrableController extends AbstractController
{
    /**
     * @Route(
     * path="api/apprenants/{id_app}/groupe/{id_gr}/livrables", 
     * 
     * methods={"POST"}
     * 
     * )
     */
    public function sendlivrable(EntityManagerInterface $em, Request $request, SerializerInterface $serializer , ApprenantRepository $repositoryApprenant)
    {
       
        if (!empty($request->getContent()))
        {
            $data=$request->getContent();
       
        }else{
            $data=$request->request->all();
        }
        $data=$serializer->decode($data, "json");
        //dd($data);
        $Livrable=new Livrable();
        if(!empty($data['libelle'])){
            $Livrable->setLibelle(($data['libelle']))
        ;}
        if(!empty($data['description'])){
            $Livrable->setDescription(($data['description']));
        }

        $user=$this->get('security.token_storage')->getToken()->getUser();
       // dd($user);
      /* $apprenant =new Apprenant();
       $apprenant->setUsername($user->getUsername())
       ->setPassword($user->getPassword())
       ->setNom($user->getNom())
       ->setPrenom($user->getPrenom());*/
      // dd($apprenant);
     /* $apprenant=$repositoryApprenant->findOneBy([
          "email"=>$user->getEmail()
      ]
      );*/
     // dd($apprenant);

        if(!empty($data['url']))
        {
            $livrableAttenduApprenants= new LivrableAttendusApprenant();
            //si on a une chaine de str separer par des virgules;
            if(gettype($data['url']) == "string")
            {
                $urls= explode(",", $data['url']);
                //dd($urls);
            } elseif(gettype($data['url']) == "array")
            {
                $urls=  $data['url'];
            }
            if($urls)
            {
                foreach ($urls as $url)
                {
                    $livrableAttenduApprenants->setUrl($url);
                    $livrableAttenduApprenants->addApprenant($user);
                    $em->persist($livrableAttenduApprenants);
                    $em->flush();
                    $Livrable->addLivrableAttendusApprenant($livrableAttenduApprenants);
                   
                    
                }
                $em->persist($Livrable);
                $em->flush();

                return $this->json($Livrable, Response::HTTP_CREATED);



            }elseif($data['livrableAttenduApprenants'] instanceof LivrableAttendusApprenant)
            {
                //si c'est une instance;
                $Livrable->addLivrableAttendusApprenant($data['livrableAttenduApprenants']);
                $em->persist($Livrable);
                $em->flush();
                return $this->json($Livrable, Response::HTTP_CREATED);
            }

        }
    }
}
