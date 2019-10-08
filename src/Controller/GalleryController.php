<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Gallery;
use App\Entity\Category;
use App\Form\GalleryType;
use App\Entity\ArtisticWork;
use App\Repository\UserRepository;
use App\Repository\GalleryRepository;
use App\Repository\CategoryRepository;
use App\Repository\ArtisticWorkRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/gallery")
 */
class GalleryController extends AbstractController
{

       /**
     * @Route("/{id}", name="gallery_index", methods={"GET"})
     */
    public function index(GalleryRepository $galleryRepository, User $user): Response
    {
        return $this->render('gallery/index.html.twig', [
          'galleries' => $galleryRepository->findBy(array('user' => $user)),
        ]);
       
        }

    // ici je tente d'envoyer la bonne galerie au click sur la categorie voulue
    /**
     * @Route("/category/{id}", name="gallery_category", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function category(Request $request, PaginatorInterface $paginator, Category $category, GalleryRepository $galleryRepository)
     {

        return $this->render('gallery/category.html.twig',[ 
         'galleries' => $paginator->paginate(
          $galleryRepository->findBy(['category' => $category]),
          $request->query->getInt('page' , 1 ),
          4),
          'category' =>$category,
        ]);
    }

     /**
     * @Route("/new/{id}", name="gallery_new", methods={"GET","POST"}, requirements={"id": "\d+"})
     */
    public function new(Request $request, User $user): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre galerie a bien été crée!');
            $gallery->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();

            return $this->redirectToRoute('gallery_edit', ['id' => $gallery->getId()]);
        }

        return $this->render('gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/edit/{id}", name="gallery_edit", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function edit(Request $request, Gallery $gallery): Response
    {
     
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre galerie a bien été mise à jour!');
            $this->getDoctrine()->getManager()->flush();
           
            return $this->redirectToRoute('gallery_edit', ['id' => $gallery->getId()]);
        }

        return $this->render('gallery/edit.html.twig', [
          
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="gallery_showUser", methods={"GET"})
     */
    public function show(Gallery $gallery): Response
    {
      
        return $this->render('gallery/show.html.twig', [
     
         'gallery'=>$gallery,
        ]);
    }

    /**
     * @Route("/gallery/{id}", name="gallery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gallery $gallery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gallery);
            $entityManager->flush();
            $this->addFlash('success', 'Votre galerie a bien été supprimée!');
        }

        return $this->redirectToRoute('gallery_index');
    }
    
}