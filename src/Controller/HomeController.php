<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Config\Loader\LoaderInterface;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;

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
        $user = $repositoryUser->findAll();
        // la je vais chercher ses catégories

       

  $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
 

        $data = $serializer->serialize($user, 'json',
        
        ['attributes' => ['id', 'firstName', 'lastName', 'location', 'categories' =>['name']]]
        );
        json_encode($data);
      
        dump($data);
     
    
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
    
    

