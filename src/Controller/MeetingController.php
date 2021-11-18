<?php
namespace App\Controller;

use App\Form\MeetingType;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends AbstractController
{

	public function __construct(private MeetingRepository $meetingRepository)
	{
		
	}

	#[Route('/', name: 'meeting.index')]
	public function index(): Response
	{
		return $this->render('meeting/index.html.twig', [
			'meetings' => $this->meetingRepository->findAll()
		]);
	}

	#[Route('/ajout', name: 'meeting.add')]
	public function add(): Response
	{
		return $this->render('meeting/add.html.twig', [
			'formMeeting' => $this->createForm(MeetingType::class)->createView()
		]);
	}

	#[Route('/meeting/{id}', name: 'meeting.detail')]
	public function detail(string $id): Response
	{
		return $this->render('meeting/detail.html.twig', [
			'meeting' => $this->meetingRepository->findOneBy(array("id" => $id))
		]);
	}

}


?>