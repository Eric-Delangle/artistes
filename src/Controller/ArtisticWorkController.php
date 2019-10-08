<?php

namespace App\Controller;

use App\Entity\ArtisticWork;
use App\Entity\Gallery;
use App\Entity\User;
use App\Entity\Category;
use App\Form\ArtisticWorkType;
use App\Repository\ArtisticWorkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/artistic-work")
 */
class ArtisticWorkController extends AbstractController
{

    /**
     * @Route("/new{id}", name="artistic_work_new", methods={"GET","POST"}, requirements={"id": "\d+" })
     */
    public function new(Request $request, Gallery $gallery): Response
    {
        $artisticWork = new ArtisticWork();
        $artisticWork->setGallery($gallery);
        $form = $this->createForm(ArtisticWorkType::class, $artisticWork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre image a bien été ajoutée!');
            $artisticWork->setCreatedAt(new \DateTime());
          //  $artisticWork->setCategory($category);
            $artisticWork->setGallery($gallery);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artisticWork);
            $entityManager->flush();

            return $this->redirectToRoute('gallery_edit', ["id" =>$gallery->getId()]);
        }

        return $this->render('artistic_work/new.html.twig', [
            'artistic_work' => $artisticWork,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artistic_work_show", methods={"GET"}, requirements={"id": "\d+" })
     */
    public function show(ArtisticWork $artisticWork): Response
    {
        return $this->render('artistic_work/show.html.twig', [
            'artistic_work' => $artisticWork,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artistic_work_edit", methods={"GET","POST"}, requirements={"id": "\d+" })
     */
    public function edit(Request $request, ArtisticWork $artisticWork): Response
    {
        $form = $this->createForm(ArtisticWorkType::class, $artisticWork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre image a bien été modifiée!');
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member');
        }

        return $this->render('artistic_work/edit.html.twig', [

            'artistic_work' => $artisticWork,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artistic_work_delete", methods={"DELETE"}, requirements={"id": "\d+" })
     */
    public function delete(Request $request, ArtisticWork $artisticWork): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artisticWork->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artisticWork);
            $entityManager->flush();
            $this->addFlash('success', 'Votre image a bien été supprimée!');
        }

        return $this->redirectToRoute('member');
    }
}
