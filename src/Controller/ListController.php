<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ListController extends Controller
{
    /**
     * @Route("/x", name="index")
     */
    public function index(Request $request)
    {

        // get current user
        if($this->getUser()) : 
            //var_dump($this->getUser()->getUsername());
            return $this->render('security/index.html.twig', array(
                'controller_name' => 'll'
            ));
        else : 
            return $this->redirectToRoute('connexion');
        endif;
    }
}