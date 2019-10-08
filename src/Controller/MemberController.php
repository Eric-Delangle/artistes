<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member")
     */
    public function index()
    {
       
        return $this->render('member/index.html.twig', [
         // 'user' => $userRepo->findAll(),
           
            'controller_name' => 'MemberController',
           // dump($userRepo)
        ]);
    }
}
