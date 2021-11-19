<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
  function __construct(private MeetingRepository $meetingRepository)
  {
  }

  #[Route('/meeting/{id}/comment/add', name: 'comment.add')]

  public function add(Request $request, string $id): Response
  {
    $comment = new Comment();
    $meeting = $this->meetingRepository->find($id);

    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $comment->setClimber($this->getUser());
      $comment->setMeeting($meeting);
      $comment->setDate(new \DateTime('@' . strtotime('now')));

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($comment);
      $entityManager->flush();

      return $this->redirectToRoute('meeting.index');
    }

    return $this->render('comment/add.html.twig', [
      'formComment' => $form->createView(),
      'meeting'     => $meeting
    ]);
  }
}
