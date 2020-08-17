<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    
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
