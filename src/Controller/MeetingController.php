<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Meeting;
use App\Form\CommentType;
use App\Form\MeetingType;
use App\Repository\ClimberMeetingRepository;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

class MeetingController extends AbstractController
{

	public function __construct(private MeetingRepository $meetingRepository, private ClimberMeetingRepository $climberMeetingRepository)
	{
	}

	#[Route('/', name: 'meeting.index')]

	public function index(): Response
	{
		return $this->render('meeting/index.html.twig', [
			'meetings' => $this->meetingRepository->findAll()
		]);
	}

	#[Route('/add', name: 'meeting.add')]

	public function add(Request $request): Response
	{
		$meeting = new Meeting();
		$form = $this->createForm(MeetingType::class, $meeting, [
			'id' => null
		]);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$meeting->setClimber($this->getUser());

			if ($meeting->getPicture() instanceof UploadedFile) {
				$fileName = ByteString::fromRandom(32)->lower();
				$extension = $meeting->getPicture()->guessClientExtension();

				$meeting->getPicture()->move('img', "$fileName.$extension");

				$meeting->setPicture("$fileName.$extension");
			}
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($meeting);
			$entityManager->flush();

			return $this->redirectToRoute('meeting.index');
		}

		return $this->render('meeting/add.html.twig', [
			'formMeeting' => $form->createView()
		]);
	}

	#[Route('/meeting/{id}', name: 'meeting.detail')]

	public function detail(Request $request, string $id): Response
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
		}

		$isRegistered = false;

		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$isRegistered = count($this->climberMeetingRepository->isClimberAlreadyRegister($this->getUser()->getId(), $meeting->getId())) > 0;
		}

		return $this->render('meeting/detail.html.twig', [
			'meeting' 			=> $this->meetingRepository->findOneBy(array("id" => $id)),
			'formComment' 	=> $form->createView(),
			'isRegistered'	=> $isRegistered
		]);
	}


	#[Route('/update/{id}', name: 'meeting.update')]

	public function update(string $id, Request $request): Response
	{
		$meeting = $this->meetingRepository->find($id);
	
		$form = $this->createForm(MeetingType::class, $meeting, [
			'id' => $id
		]);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			//	dd($meeting);
			$meeting->setClimber($this->getUser());

			if ($meeting->getPicture() instanceof UploadedFile) {
				$fileName = ByteString::fromRandom(32)->lower();
				$extension = $meeting->getPicture()->guessClientExtension();

				$meeting->getPicture()->move('img', "$fileName.$extension");

				$meeting->setPicture("$fileName.$extension");

				if($meeting->getId()){
					unlink("img/{$meeting->prevImage}");
				}
			}
			else{
				$meeting->setPicture($meeting->prevImage);
			}
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($meeting);
			$entityManager->flush();

			return $this->redirectToRoute('meeting.detail',["id" => $id]);
		}

		return $this->render('meeting/update.html.twig', [
			'meeting' 			=> $meeting,
			'formMeeting' => $form->createView()
		]);
	}
}
