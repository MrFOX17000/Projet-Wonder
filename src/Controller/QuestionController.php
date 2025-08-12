<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\QuestionType;

final class QuestionController extends AbstractController
{
    #[Route('/question/ask', name: 'question_form')]
    public function index(Request $request): Response
    {

        $formQuestion = $this->createForm(QuestionType::class);

        $formQuestion->handleRequest($request);

        if ($formQuestion->isSubmitted() && $formQuestion->isValid()) {
        }

        return $this->render('question/index.html.twig', [
            'form' => $formQuestion->createView(),
        ]);
    }

    #[Route('/question/{id}', name: 'question_show')]
    public function show(Request $request, int $id): Response
    {

        $question = [
                'title' => 'Je suis une super question',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'rating' => 20,
                'author' => ['name' => 'Jean Dupont', 'avatar' => 'https://randomuser.me/api/portraits/men/44.jpg'],
                'nbrOfResponse' => 15,
        ];

        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }
}
