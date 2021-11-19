<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, array('data' => $options['id']))
            ->add('date', DateTimeType::class, array('widget' => 'single_text'))
            ->add('location')
            ->add('limit_climber')
            ->add('picture', FileType::class, [
                'constraints' => $options['id']
                    ?[]
                    : [new NotBlank([ 'message' => "Pas d'image sélectionnée"])],
                'data_class' => null
            ])
            ->add('title')
            ->add('description')
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'choice_label' => 'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'id'         => null
        ]);
    }
}
