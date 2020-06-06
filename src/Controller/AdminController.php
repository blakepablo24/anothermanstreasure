<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Entity\FreeItem;
use App\Form\NewFreeItemType;
use App\Form\AddNewCategoryType;

/**
 * @Route("/admin")
*/

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_main_page")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/post-free-item", name="post_free-item", methods={"GET","POST"})
     */
    public function postFreeItem(Request $request)

    {

        $freeItem = new FreeItem();
        $form = $this->createForm(NewFreeItemType::class, $freeItem);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $freeItem->setTitle($request->request->get('new_free_item')['title']);
            $freeItem->setDescription($request->request->get('new_free_item')['description']);

            $category = $request->request->get('new_free_item')['category'];
            $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
            $category = $repository->find($category);
            $freeItem->setCategory($category);
            
            $freeItem->setLocation($request->request->get('new_free_item')['location']);
            $freeItem->setDate(new \DateTime());
            $freeItem->setTime(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($freeItem);
            $entityManager->flush();

            return $this->redirectToRoute('main_page');

        }

        return $this->render('admin/post-free-item.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/categories", name="categories", methods={"GET","POST"})
     */
    public function categories(Request $request)

    {

        return $this->render('admin/categories.html.twig');

    }

    /**
     * @Route("/categories-add-new-category", name="add_new_category", methods={"GET", "POST"})
     */
    Public function addNewCategory(Request $request)

    {

        $newCategory = new Category();
        $form = $this->createForm(AddNewCategoryType::class, $newCategory);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $newCategory->setName($request->request->get('add_new_category')['name']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newCategory);
            $entityManager->flush();

            $this->addFlash('new_category_added', 'New category successfully added!');

            return $this->redirectToRoute('categories');

        }

        return $this->render('admin/categories-add-new-category.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
