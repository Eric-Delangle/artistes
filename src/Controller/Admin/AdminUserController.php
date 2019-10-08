<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AbstractController
{

    /**
     * @Route("/admin/users", name="user_index", methods={"GET"})
     */
    public function indexUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/users/users.html.twig', [
           
            'users' => $userRepository->findAll(),
        ]);
    }

  

    /**
     * @Route("/admin/users", name="user_show", methods={"GET"})
     */

    public function showUsers(User $user, Category $category): Response
    {
        return $this->render('admin/users/users.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/users/edit/{id}", name="user_editUser", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/users/userEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/users/delete/{id}", name="user_deleteUser", methods={"DELETE"})
     */
    public function deleteUser(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
    
}