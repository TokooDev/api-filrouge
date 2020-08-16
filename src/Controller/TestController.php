<?php

namespace App\Controller;

use App\Entity\Test;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/tests",
     *     name="addTest",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\TestController::addTest",
     *          "__api_resource_class"=Test::class,
     *          "__api_collection_operation_name"="addTest"
     *     }
     * )
     */
    public function addTest(Request $request, EntityManagerInterface $manager)
        {
            $doc = $request->files->get("document");
            $file= IOFactory::identify($doc);
            $reader= IOFactory::createReader($file);
            $spreadsheet=$reader->load($doc);
            $array_contenu_fichier= $spreadsheet->getActivesheet()->toArray();
            //dd($array_contenu_fichier);
            for ($i=0;$i<count($array_contenu_fichier);$i++){
                if ($i>0){
                        $test=new Test();
                        $test->setPrenom($array_contenu_fichier[$i][0]);
                        $test->setNom($array_contenu_fichier[$i][1]);
                        $manager->persist($test);
                }
            }
            $manager->flush();
            return $this->json($test,201);
        }
}
