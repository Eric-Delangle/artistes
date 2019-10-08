<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('password_verify', PasswordType::class)
            ->add('firstName')
            ->add('lastName')
            ->add('location')
            ->add('categories', EntityType::class, [ 
                'class' => Category::class,
                 'choice_label' => 'name',
                 'multiple' => true,
                 'expanded' => true
              ]) 
         ;
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms',
        ]);
    }
}

