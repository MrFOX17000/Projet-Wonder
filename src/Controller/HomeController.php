<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $questions = [
            [   
                'id'=> 1,
                'title' => 'Je suis une super question',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'rating' => 20,
                'author' => ['name' => 'Jean Dupont', 'avatar' => 'https://randomuser.me/api/portraits/men/44.jpg'],
                'nbrOfResponse' => 15,
            ],
            [   
                'id'=> 2,
                'title' => 'Je suis une super question',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'rating' => 0,
                'author' => ['name' => 'Jane Rae', 'avatar' => 'https://randomuser.me/api/portraits/women/90.jpg'],
                'nbrOfResponse' => 7,
            ],
            [   
                'id'=> 3,
                'title' => 'Je suis une super question',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'rating' => -15,
                'author' => ['name' => 'John Doe', 'avatar' => 'https://randomuser.me/api/portraits/men/64.jpg'],
                'nbrOfResponse' => 2,
            ]
        ];

        return $this->render('home/index.html.twig', [
            'questions' => $questions
        ]);
    }
}
