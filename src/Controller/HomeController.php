<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em): Response
    {
        // https://randomuser.me/api/portraits/women/90.jpg
        $questionRepo = $em->getRepository(Question::class);
        $questions = $questionRepo->findAll();
        return $this->render('home/index.html.twig', [
            'questions' => $questions
        ]);
    }
}
