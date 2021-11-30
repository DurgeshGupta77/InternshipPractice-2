<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController{
    /**
     * @Route("/", name="home")
     */
    
    public function renderRegisterPage():Response{
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            //Logged In
            return $this->render('home.html.twig');
        }
        else{
            //Not logged In
            return $this->redirectToRoute('login');            
        }               
    }
}
?>