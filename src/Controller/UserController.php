<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     * name="userList",
     * path="api/admin/users",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\Controller\UserController::showUser",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="getUsers"
     * }
     * )
     */
    public function showUser(UserRepository $repo)
    {
        $apprenants= $repo->findByArchived("0");
        return $this->json($apprenants,Response::HTTP_OK,);

    }

    /**
     * @Route(
     * name="userOfProfilList",
     * path="api/admin/users",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\Controller\UserController::showUserOProfil",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="getUsersOfProfil"
     * }
     * )
     */
    public function showUserOProfil(UserRepository $repo)
    {
        $apprenants= $repo->findByArchived("0");
        return $this->json($apprenants,Response::HTTP_OK,);

    }
    
    public function addUser(Request $request, SerializerInterface $serialize,UserPasswordEncoderInterface $encoder,EntityManagerInterface $entity)
    {
         
        $User_json = $request->request->all();
        $image = $request->files->get("avatar");
        $User = $serialize ->denormalize($User_json,"App\Entity\User",true);
        $image = fopen($image->getRealPath(),"rb");
        $User -> setAvatar($image);
        $User ->setArchived(0);
        $password = $User -> getPassword();
        $User -> SetPassword($encoder->encodePassword($User, $password));
        $entity -> persist($User);
        $entity -> flush();
        fclose($image);
        return $this->json("succes",201);

        
    }
}
