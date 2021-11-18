<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ClimberController extends AbstractController
{
   function __construct(private UrlGeneratorInterface $urlGenerator)
   {
   }

   #[Route('/account', name: 'climber.account')]

   public function account(): Response
   {
      if ($this->isGranted('IS_AUTHENTIFICATED_FULLY')) {
         return $this->render('climber/account.html.twig');
      }

      return new RedirectResponse($this->urlGenerator->generate('meeting.index'));
   }
}
