<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Gallery;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\GalleryRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicProfileController extends AbstractController
{

    // la une liste publique de tous les membres
    /**
     * @Route("/public/profile", name="public_profile")
     */
    public function index(UserRepository $userRepo)
    {
        return $this->render('public_profile/index.html.twig', [
      
            'users' => $userRepo->findAll(),     
        ]);
    }

    // la au click je veux le profil du membre
     /**
     * @Route("/public_show/{slug}", name="public_show", methods={"GET"})
     */
     
    public function show($slug, User $user, UserRepository $userRepo, CategoryRepository $categoryRepo, GalleryRepository $galleryRepo)
    {
        return $this->render('public_profile/show.html.twig', [
      
            'users' => $userRepo->findOneBySlug(['slug' => $slug]), 
            'categories' => $categoryRepo, 
            'gallery' => $galleryRepo->findBy(['user' => $user]),   
        ]);
    }
}
