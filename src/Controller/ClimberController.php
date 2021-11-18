<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClimberController extends AbstractController
{
//   #[Route('/login', name: 'climber.login')]

//   public function login(): Response {
//      return $this->render('climber/login.html.twig');
//   }
  
  #[Route('/register', name: 'climber.register')]

  public function register(): Response {
     return $this->render('climber/register.html.twig');
  }
  
  #[Route('/my-account', name: 'climber.account')]

  public function account(): Response {
     return $this->render('climber/account.html.twig');
  }
}