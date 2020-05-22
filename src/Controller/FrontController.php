<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index()

    {

        return $this->render('front/index.html.twig');

    }

    /**
     * @Route("/free-item-list/category/{categoryname},{id}", name="free_item_list")
     */
    public function freeItemlist()

    {

        return $this->render('front/free-item-list.html.twig');

    }

    public function categories()

    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('front/_categories.html.twig', [
            'categories' => $categories
        ]);

    }

}
