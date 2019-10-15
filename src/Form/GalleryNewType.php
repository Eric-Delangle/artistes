<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Gallery;
use App\Entity\Category;
use App\Entity\ArtisticWork;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class GalleryNewType extends AbstractType
{
   
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
      
        
        $builder
            ->add('name')
            
            ->add('category')
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
            'translation_domain' => 'forms',
        ]);
    }
}