<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\FreeItem;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/all-categories", name="all_categories")
     */
    public function allCategories()

    {

        return $this->render('front/categories.html.twig');

    }

    /**
     * @Route("/free-item-list/category/{categoryname},{id}", methods={"GET"}, name="free_item_list")
     */
    public function freeItemlist(Category $category, Request $request)

    {

        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy(['category' => $category], ['date' => 'DESC', 'time' => 'DESC'], 8);

        return $this->render('front/free-item-list.html.twig', [
            'category' => $category,
            'freeItems' => $freeItems
        ]);

    }

    /**
     *  @Route("/search-results", methods={"GET"}, name="search_results")
     */
    public function searchResults(Request $request)

    {

        $data = $request->get('search');

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery
        (
            'SELECT f FROM App\Entity\FreeItem f WHERE f.title LIKE :data'
        )
        ->setParameter('data', '%'.$data.'%');

        $results = $query->getResult();

        return $this->render('front/search-results.html.twig', [
            'freeItems' => $results,
            'searchTerm' => $data
        ]);

    }

    /**
     * @Route("/free-item-single/{id}", name="free_item_single", methods={"GET"})
     */
    public function freeItemSingle(Request $request, FreeItem $freeItem)

    {

        return $this->render('front/free-item-single.html.twig', [
            'freeItem' => $freeItem
        ]);

    }

    public function categories()

    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('front/includes/_categories.html.twig', [
            'categories' => $categories
        ]);

    }

    public function allFreeItems()

    {
        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy([], ['date' => 'DESC', 'time' => 'DESC'], 8);

        return $this->render('front/includes/_free-items.html.twig', [
            'freeItems' => $freeItems
        ]);

    }

    private function prepareQuery(string $query): array

    {

        return explode(' ', $query);

    }

}
