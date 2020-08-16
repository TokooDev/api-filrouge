<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @var EntityManagerInterface
 */
class UserController extends AbstractController
{
    private $archived;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->archived = $manager;
    }
    
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

    /**
     * @Route(
     * name="addUser",
     * path="api/admin/users",
     * methods={"POST"},
     * defaults={
     * "_controller"="\app\Controller\UserController::addUser",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="addUser"
     * }
     * )
     */
    public function addUser(Request $request,UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager,\Swift_Mailer $mailer)
    {
        $user = $request->request->all();
        $avatar = $request->files->get("avatar");
        $avatar = fopen($avatar->getRealPath(),"rb");
        $user->setAvatar($avatar);
        $user = $serializer->denormalize($user,"App\Entity\User");
        $errors = $validator->validate($user);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $password = "sonatel";
        $user->setPassword($encoder->encodePassword($user,$password));
        $user->setArchived(0);
        $manager->persist($user);
        $manager->flush();
        fclose($avatar);
        /*$message=(new\Swift_Message)
            ->setSubject('Orange Digital Center, SONATEL ACADEMY')
            ->setFrom('mainashou@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("Bienvenue cher apprenant vous avez intégré la promotion de la première école de codage gratuite du Sénégal, veuillez utiliser ce login: ".$user->getLogin()." et ce password : ".$password." par defaut pour se connecter");
        $mailer->send($message);*/
        return $this->json($serializer->normalize($user),Response::HTTP_CREATED);
    }

    /**
     * @Route(
     * name="archiverUser",
     * path="api/users/{id}/archived",
     * methods={"PUT"},
     * defaults={
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="archiverUser"
     * }
     * )
     */
    
    public function __invoke(User $data): User
    {
        $data->setArchived(1);
        $this->archived->flush();
        return $data;
    }
    
}
