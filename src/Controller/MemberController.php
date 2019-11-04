<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
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

            'controller_name' => 'MemberController',
        ]);
    }

}
