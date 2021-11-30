<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Registration_Controller extends AbstractController{
    public function index(UserPasswordHasherInterface $passwordHasher){
        $user = new User();
        $plaintextPassword = $user->getPassword();

        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);
    }
} 
?>