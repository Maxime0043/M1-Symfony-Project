<?php

namespace App\Controller;

use App\Entity\ClimberMeeting;
use App\Repository\ClimberMeetingRepository;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClimberController extends AbstractController
{
   function __construct(private MeetingRepository $meetingRepository, private ClimberMeetingRepository $climberMeetingRepository)
   {
   }

   #[Route('/account', name: 'climber.account')]

   public function account(): Response
   {
      // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
      if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
         return $this->redirectToRoute('security.login');
      }

      $roles = explode('_', $this->getUser()->getRoles()[0]);
      $picture = strtolower($roles[1]);

      // On dirige l'utilisateur vers sa page de compte
      return $this->render('climber/account.html.twig', [
         'picture'   => $picture
      ]);
   }

   #[Route('/meeting/{id}/participate', name: 'climber.participate')]

   public function participate($id): Response
   {
      // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
      if (!$this->isGranted('IS_AUTHENTICATED_FULLY'))
         return $this->redirectToRoute('security.login');

      $meeting = $this->meetingRepository->find($id);

      // On vérifie si l'utilisateur participe à la Journée Découverte
      $isAlreadyParticipating = count($this->climberMeetingRepository->isClimberAlreadyRegister($this->getUser()->getId(), $meeting->getId())) > 0;

      // Si l'utilisateur participe déjà à la Journée Découverte, on le redirige vers la page d'accueil
      if ($isAlreadyParticipating) {
         $this->addFlash('meetingParticipation', 'Vous participez déjà à la Journée Découverte "' . $meeting->getTitle() . '" du ' . $meeting->getDate()->format('d/m/Y H:i:s') . '.');
         return $this->redirectToRoute('meeting.index');
      }

      // On définit que l'utilisateur participe à la Journée Découverte courante dans la base de données
      $climberMeeting = new ClimberMeeting();
      $climberMeeting->setClimber($this->getUser());
      $climberMeeting->setMeeting($meeting);
      $climberMeeting->setHasParticipated(false);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($climberMeeting);
      $entityManager->flush();

      // On dirige l'utilisateur vers la liste des Journées Découverte
      return $this->redirectToRoute('meeting.index');
   }
}
