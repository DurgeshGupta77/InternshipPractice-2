<?php
namespace App\Controller;
//This is Custom Registration Page does not do anything just template
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegisterPage extends AbstractController{
    /**
     * @Route("/register/me", name="register_page")
     */
    public function renderRegisterPage():Response{
        return $this->render('myregister.html.twig');       
    }
}
?>