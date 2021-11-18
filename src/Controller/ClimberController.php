<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ClimberController extends AbstractController
{
   function __construct(private UrlGeneratorInterface $urlGenerator, private LevelRepository $levelRepository)
   {
   }

   #[Route('/account', name: 'climber.account')]

   public function account(): Response
   {
      if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
         return $this->render('climber/account.html.twig');
      }

      return new RedirectResponse($this->urlGenerator->generate('meeting.index'));
   }
}
