<?php

namespace App\Controller;

use App\Entity\Climber;
use App\Form\RegistrationFormType;
use App\Repository\LevelRepository;
use App\Security\LogInFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    function __construct(private LevelRepository $levelRepository)
    {
    }

    #[Route('/register', name: 'security.register')]

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, LogInFormAuthenticator $login): Response
    {
        $user = new Climber();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setPoints(0);
            $user->setRoles($this->levelRepository->getBasicLevel()[0]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('meeting.index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
