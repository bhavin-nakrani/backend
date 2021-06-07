<?php

namespace App\Controller;

use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    private $setting;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setting = $entityManager->getRepository(Setting::class)->findOneBy([], ['id' => 'desc']);
    }

    public function getSetting()
    {
        return $this->setting;
    }
}
