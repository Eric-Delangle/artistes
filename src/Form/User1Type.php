<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class,['required'=>false])
            ->add('password_verify', PasswordType::class,['required'=>false])
            ->add('firstName')
            ->add('lastName')
            ->add('location')
            ->add('categories', EntityType::class, [ 
                'class' => Category::class,
                 'choice_label' => 'name',
                 'multiple' => true,
                 'expanded' => true
              ]) 
              ->add('avatarFile', VichFileType::class, [
                'required' =>false,
                'label' =>'Votre avatar',
           ])
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
