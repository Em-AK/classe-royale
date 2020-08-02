<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        if ($this->getUser()) {
            foreach ($this->getUser()->getRoles() as $role) {
                if ($role == "ROLE_ADMIN") {
                    return $this->redirectToRoute('admin');
                }
                elseif ($role == "ROLE_DIRECTOR") {
                    return $this->redirectToRoute('director');
                }
                elseif ($role == "ROLE_TEACHER") {
                    return $this->redirectToRoute('teacher');
                }
                elseif ($role == "ROLE_PARENT") {
                    return $this->redirectToRoute('parent');
                }
            }
        }
        else {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/index.html.twig');
    }
}
