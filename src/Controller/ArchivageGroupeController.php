<?php

namespace App\Controller;

use App\Entity\Groupe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @var EntityManagerInterface
 */
class ArchivageGroupeController extends AbstractController
{
    private $archived;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->archived= $manager;
    }
    public function __invoke(Groupe $data): Groupe
    {
        $data->setArchived(1);
        $this->archived->flush();
        return $data;
    }
}
