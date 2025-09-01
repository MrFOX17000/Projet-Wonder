<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CommentType;
use App\Entity\Comment;
use App\Repository\VoteRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Vote;
use App\Repository\QuestionRepository;

class QuestionController extends AbstractController
{
  #[Route('/question/ask', name: 'question_form')]
  #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
  public function index(Request $request, EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    $question = new Question();
    $formQuestion = $this->createForm(QuestionType::class, $question);

    $formQuestion->handleRequest($request);

    if ($formQuestion->isSubmitted() && $formQuestion->isValid()) {
      $question->setNbrOfResponse(0);
      $question->setRating(0);
      $question->setAuthor($user);
      $question->setCreatedAt(new \DateTimeImmutable());
      $em->persist($question);
      $em->flush();
      $this->addFlash('success', 'Votre question a été ajoutée');
      return $this->redirectToRoute('home');
    }

    return $this->render('question/index.html.twig', [
      'form' => $formQuestion->createView(),
    ]);
  }

  #[Route('/question/{id}', name: 'question_show')]
  public function show(Request $request, QuestionRepository $questionRepo, int $id, EntityManagerInterface $em): Response
  {
    $question = $questionRepo->getQuestionWithCommentsAndAuthors($id);
    $options = ['question' => $question];
    $user = $this->getUser();

    if($user) {
      $comment = new Comment();
      $commentForm = $this->createForm(CommentType::class, $comment);
      $commentForm->handleRequest($request);
      if($commentForm->isSubmitted() && $commentForm->isValid()){
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setRating(0);
        $comment->setQuestion($question);
        $comment->setAuthor($user);
        $question->setNbrOfResponse($question->getNbrOfResponse() + 1);
        $em->persist($comment);
        $em->flush();
        $this->addFlash('success', 'Votre réponse a bien été ajoutée');
        return $this->redirect($request->getUri());
      }
      $options['form'] = $commentForm->createView();
    }  

    return $this->render('question/show.html.twig', $options);
  }

  #[Route('/question/rating/{id}/{score}', name: 'question_rating')]
  #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
  public function ratingQuestion(Request $request,VoteRepository $voteRepo, Question $question, int $score, EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    if ($question->getAuthor() !== $user) {
      $vote = $voteRepo->findOneBy(['author' => $user, 'question' => $question]);
      if($vote){
        if(($vote->IsLiked() && $score > 0) || (!$vote->IsLiked() && $score < 0)) {
          $em->remove($vote);
          $question->setRating($score > 0 ? $question->getRating() - 1 : $question->getRating() + 1);
        } else {
          $vote->setIsLiked(!$vote->IsLiked());
          $question->setRating($score > 0 ? $question->getRating() + 2 : $question->getRating() - 2);
        } 
      } else {
        $vote = new Vote();
        $vote->setAuthor($user);
        $vote->setQuestion($question);
        $vote->setIsLiked($score > 0 ? true : false);
        $question->setRating($question->getRating() + $score);
        $em->persist($vote);
      }
      $em->flush();
    }else {
      $this->addFlash('warning', 'Vous ne pouvez pas voter pour votre propre question');
    }
    $referer = $request->server->get('HTTP_REFERER');
    return $referer ? $this->redirect($referer) : $this->redirectToRoute('home');
}

  #[Route('comment/rating/{id}/{score}', name: 'comment_rating')]
  #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
  public function ratingComment(Request $request, Comment $comment, VoteRepository $voteRepo, int $score, EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    if ($comment->getAuthor() !== $user) {
      $vote = $voteRepo->findOneBy(['author' => $user, 'comment' => $comment]);
      if($vote){
        if(($vote->IsLiked() && $score > 0) || (!$vote->IsLiked() && $score < 0)) {
          $em->remove($vote);
          $comment->setRating($score > 0 ? $comment->getRating() - 1 : $comment->getRating() + 1);
        } else {
          $vote->setIsLiked(!$vote->IsLiked());
          $comment->setRating($score > 0 ? $comment->getRating() + 2 : $comment->getRating() - 2);
        } 
      } else {
        $vote = new Vote();
        $vote->setAuthor($user);
        $vote->setComment($comment);
        $vote->setIsLiked($score > 0 ? true : false);
        $comment->setRating($comment->getRating() + $score);
        $em->persist($vote);
      }
      $em->flush();
    }else {
      $this->addFlash('warning', 'Vous ne pouvez pas voter pour votre propre commentaire');
    }
    $referer = $request->server->get('HTTP_REFERER');
    return $referer ? $this->redirect($referer) : $this->redirectToRoute('home');
  }
}