<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MeetingType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('location')
            ->add('limit_climber')
            ->add('picture')
            ->add('title')
            ->add('description')
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'choice_label' => 'name'])
            ->add('climber', HiddenType::class, array('data' => $this->security->getUser()->getId()))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}
