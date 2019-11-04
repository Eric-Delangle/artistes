<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('location')
            ->add('niveau')
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                 'choice_label' => 'name',
                 'multiple' => 'true'
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

