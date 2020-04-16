<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Category;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // la je tente d'appeler la categorie de l'utilisateur pour l'afficher en js sur la carte
    public function constructor($category) {
        $this->category = $category;
    }
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    // la je veux que quand on arrive sur le site sans rien taper on tombe sur cette page
      /**
     * @Route(" / ", name="home")
     */
    public function home()
    {
        return $this->render('home/home.html.twig');
    }

    /* la je veux recuperer les lieux de mes membres en bases de données afin de les transformer en json
    et pouvoir les afficher sur la map */
     /**
     * @Route("/", name="home")
     */
    public function membersLocations(SerializerInterface $serializer) {

        //je récupere le repository des users et je vais checher ses infos
        $repositoryCat = $this->getDoctrine()->getRepository(Category::class);
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $repositoryMess = $this->getDoctrine()->getRepository(Message::class);
        $user = $repositoryUser->findAll();

        // la je vais chercher ses catégories

            $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);


            $data = $serializer->serialize($user, 'json',
            
            ['attributes' => ['id', 'firstName', 'lastName', 'slug', 'location', 'categories' =>['name'], 'messages' =>['message']]]
            );
            json_encode($data);
            


            // Création du fichier json user

            // Nom du fichier à créer
            $members = 'members.json';

            // Ouverture du fichier
            $members = fopen($members, 'w+');

            // Ecriture dans le fichier
            fwrite($members, $data);
            

            // Fermeture du fichier
            fclose($members);
                    
                    return $this->render('home/home.html.twig');

        }
    }
    
    

