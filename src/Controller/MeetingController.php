<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends AbstractController
{
	#[Route('/', name: 'meeting.index')]
	public function index(): Response
	{
		return $this->render('meeting/index.html.twig');
	}
}


?>