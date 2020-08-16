<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Apprenant;
use App\Repository\ProfilRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PromoController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/admin/promos",
     *     name="addPromo",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\PromoController::addPromo",
     *          "__api_resource_class"=Promo::class,
     *          "__api_collection_operation_name"="addPromo"
     *     }
     * )
     */
    public function addPromo(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager,\Swift_Mailer $mailer, ProfilRepository $repoProfil)
    {
        $promo=new Promo();
        $promo->setTitre("Sonatel Academy")
            ->setLangue("Français")
            ->setLieu("ORANGE DIGITAL CENTER, MERMOZ DAKAR")
            ->setArchived(0)
        ;
        $groupe=new Groupe();
        $groupe->setArchived(1)
            ->setLibelle("Groupe principal")
            ->setDateCreation(new \DateTime)
        ;
        $doc = $request->files->get("document");
        $file= IOFactory::identify($doc);
        $reader= IOFactory::createReader($file);
        $spreadsheet=$reader->load($doc);
        $fichierexcel= $spreadsheet->getActivesheet()->toArray();
        //dd($fichierexcel);
        $password="sonatel";
        for ($i=1;$i<count($fichierexcel);$i++){
            $apprenant = new Apprenant();
            $apprenant->addGroupe($groupe)
                ->setStatut("actif");
            $user=new User();
            $user->setUsername($fichierexcel[$i][0])
                ->setPassword($encoder->encodePassword($user,$password))
                ->setNom($fichierexcel[$i][1])
                ->setPrenom($fichierexcel[$i][2])
                ->setTel($fichierexcel[$i][3])
                ->setEmail($fichierexcel[$i][4])
                ->setGenre($fichierexcel[$i][5])
                ->setArchived(0)
            ;
            $user->setProfil($repoProfil->findOneByLibelle("Apprenant"));
            $apprenant->setUser($user);
            $groupe->addApprenant($apprenant);

            $manager->persist($user);
            $manager->persist($apprenant);

            $message=(new\Swift_Message)
                ->setSubject('SONATEL ACADEMY')
                ->setFrom('loaminata082@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Bonsoir Cher(e) candidat(e) à la sonatel Academy. \n Après les différentes étapes de sélection que tu as passé avec brio, nous t’informons que ta candidature a été retenue pour intégrer la promotion cette anné de la première école de codage gratuite du Sénégal.\n Rendez-vous sur www.sonatelacademy.sn et voici vos informations de connexion :\n Username: ".$user->getUsername()." \n Password : ".$password." ");
            $mailer->send($message);
        }
        $promo->addGroupe($groupe);
        //dd($promo);
        $errors = $validator->validate($promo);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $manager->persist($groupe);
        $manager->persist($promo);
        $manager->flush();
        return $this->json($serializer->normalize($promo), Response::HTTP_CREATED);
    }
}
