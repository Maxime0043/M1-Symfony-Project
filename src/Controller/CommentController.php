<?php

namespace App\Controller;

use App\Form\CommentType;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
  function __construct(private MeetingRepository $meetingRepository)
  {
  }

  #[Route('/meeting/{id}/comment/add', name: 'comment.add')]

  public function add(string $id): Response
  {
    return $this->render('comment/add.html.twig', [
      'formComment' => $this->createForm(CommentType::class, null, [
        'id' => $id
      ])->createView(),
      'meeting'     => $this->meetingRepository->find($id)
    ]);
  }
}
