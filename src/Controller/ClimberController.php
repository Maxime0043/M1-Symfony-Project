<?php

namespace App\Controller;

use App\Entity\ClimberMeeting;
use App\Entity\Level;
use App\Repository\ClimberMeetingRepository;
use App\Repository\ClimberRepository;
use App\Repository\LevelRepository;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClimberController extends AbstractController
{
   function __construct(private MeetingRepository $meetingRepository, 
                        private ClimberMeetingRepository $climberMeetingRepository, 
                        private ClimberRepository $climberRepository,
                        private LevelRepository $levelRepository)
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

      // On récupère les Journées Découverte auquelles l'utilisateur s'est inscrit et a participé
      $nonParticipatedMeetings = $this->climberMeetingRepository->getNonParticipatedMeetings($this->getuser()->getid());
      $participatedMeetings = $this->climberMeetingRepository->getParticipatedMeetings($this->getuser()->getid());

      // On dirige l'utilisateur vers sa page de compte
      return $this->render('climber/account.html.twig', [
         'picture'                  => $picture,
         'nonParticipatedMeetings'  => $nonParticipatedMeetings,
         'participatedMeetings'     => $participatedMeetings
      ]);
   }

   #[Route('/meeting/{id}/participate', name: 'climber.participate')]

   public function participate($id): Response
   {
      // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
      if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
         return $this->redirectToRoute('security.login');
      }

      $meeting = $this->meetingRepository->find($id);

      // On vérifie si l'utilisateur participe à la Journée Découverte
      $isAlreadyParticipating = count($this->climberMeetingRepository->isClimberAlreadyRegister($this->getUser()->getId(), $meeting->getId())) > 0;

      // Si l'utilisateur participe déjà à la Journée Découverte, on le redirige vers la page d'accueil
      if ($isAlreadyParticipating) {
         $this->addFlash('meetingParticipationError', 'Vous participez déjà à la Journée Découverte "' . $meeting->getTitle() . '" du ' . $meeting->getDate()->format('d/m/Y H:i:s') . '.');
         return $this->redirectToRoute('meeting.index');
      }

      // Si la capacité d'inscription maximal de la Journée Découverte est dépassée, on le redirige vers la liste des Journées Découverte
      if (count($meeting->getClimberMeetings()) >= $meeting->getLimitClimber()) {
         $this->addFlash('meetingParticipationError', 'La limite d\'inscription pour cette Journée Découverte a été atteinte. Vous ne pouvez donc pas vous y inscrire.');
         return $this->redirectToRoute('meeting.index');
      }


      // Si l'utilisateur n'a pas le niveau requis, on le redirige vers la liste des Journées Découverte
      if ($this->getUser()->getPoints() < $meeting->getLevel()->getPointsNeeded()) {
         $this->addFlash('meetingParticipationError', 'Vous n\'avez pas le niveau requis pour participer à cette Journée Découverte.');
         $this->addFlash('meetingParticipationError', 'Niveau requis: ' . $meeting->getLevel()->getName());
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

   #[Route('/meeting/{id}/hasParticipated/{id_climber}', name: 'climber.hasParticipated')]

   public function hasParticipated($id, $id_climber){

      $climberMeeting = $this->climberMeetingRepository->findOneBy(array('meeting' => $id, 'climber' => $id_climber));
      $climberMeeting->setHasParticipated(true);
      
      $climber = $this->climberRepository->find($id_climber);

      $points = $climber->getPoints();
      $points += 1;
      $climber->setPoints($points);

      $levelClimber = new Level;

      $levels = $this->levelRepository->getLevels();
      foreach ($levels as $level) {
         if($points >= $level->getPointsNeeded()){
            $levelClimber = $level;
         }
      }

      $climber->setRoles($levelClimber);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($climberMeeting);
      $entityManager->persist($climber);
      $entityManager->flush();

      return $this->redirectToRoute('meeting.detail', ["id" => $id]);
   }

   #[Route('/meeting/{id}/hasParticipatedCancel/{id_climber}', name: 'climber.hasParticipatedCancel')]

   public function hasParticipatedCancel($id, $id_climber){

      $climberMeeting = $this->climberMeetingRepository->findOneBy(array('meeting' => $id, 'climber' => $id_climber));
      $climberMeeting->setHasParticipated(false);

      $climber = $this->climberRepository->find($id_climber);

      $points = $climber->getPoints();
      $points -= 1;
      $climber->setPoints($points);

      $levelClimber = new Level;

      $levels = $this->levelRepository->getLevels();
      foreach ($levels as $level) {
         if($points >= $level->getPointsNeeded()){
            $levelClimber = $level;
         }
      }

      $climber->setRoles($levelClimber);


      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($climberMeeting);
      $entityManager->flush();

      return $this->redirectToRoute('meeting.detail', ["id" => $id]);
   }
}
