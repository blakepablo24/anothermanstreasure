<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\FreeItemPictures;
use App\Form\NewFreeItemType;
use App\Form\AddNewCategoryType;
use App\Form\EditCategoryType;
// Image uploads
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'freeItems' => $freeItems,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/post-free-item", name="post_free-item", methods={"GET","POST"})
     */
    public function postFreeItem(Request $request, SluggerInterface $slugger)

    {

        $freeItem = new FreeItem();
        $form = $this->createForm(NewFreeItemType::class, $freeItem);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $freeItem->setTitle($request->request->get('new_free_item')['title']);
            $freeItem->setDescription($request->request->get('new_free_item')['description']);

            // Does it have a picture attached to the free Item
            $picture01 = $form->get('picture01')->getData();
            
            if ($picture01) {
                $originalFilename = pathinfo($picture01->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture01->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture01->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $freeItemPicture = new FreeItemPictures();

                $freeItemPicture->setName($newFilename);

                $freeItemPicture->setFreeItem($freeItem);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($freeItemPicture);

            }

            $picture02 = $form->get('picture02')->getData();
            
            if ($picture02) {
                $originalFilename = pathinfo($picture02->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture02->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture02->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $freeItemPicture = new FreeItemPictures();

                $freeItemPicture->setName($newFilename);

                $freeItemPicture->setFreeItem($freeItem);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($freeItemPicture);

            }

            $picture03 = $form->get('picture03')->getData();
            
            if ($picture03) {
                $originalFilename = pathinfo($picture03->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture03->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture03->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $freeItemPicture = new FreeItemPictures();

                $freeItemPicture->setName($newFilename);

                $freeItemPicture->setFreeItem($freeItem);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($freeItemPicture);

            }

            $picture04 = $form->get('picture04')->getData();
            
            if ($picture04) {
                $originalFilename = pathinfo($picture04->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture04->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture04->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $freeItemPicture = new FreeItemPictures();

                $freeItemPicture->setName($newFilename);

                $freeItemPicture->setFreeItem($freeItem);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($freeItemPicture);

            }

            $picture05 = $form->get('picture05')->getData();
            
            if ($picture05) {
                $originalFilename = pathinfo($picture05->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture05->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture05->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $freeItemPicture = new FreeItemPictures();

                $freeItemPicture->setName($newFilename);

                $freeItemPicture->setFreeItem($freeItem);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($freeItemPicture);

            }

            $picture06 = $form->get('picture06')->getData();
            
            if ($picture06) {
                $originalFilename = pathinfo($picture06->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture06->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture06->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $freeItemPicture = new FreeItemPictures();

                $freeItemPicture->setName($newFilename);

                $freeItemPicture->setFreeItem($freeItem);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($freeItemPicture);

            }

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
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

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

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/edit-category/{id}", name="edit_category", methods={"GET","POST"})
     */
    public function editCategory(Request $request, Category $category)

    {
        $categoryToEdit = $this->getDoctrine()->getRepository(Category::class)->find($category);

        $form = $this->createForm(EditCategoryType::class, $categoryToEdit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $categoryToEdit->setName($request->request->get('edit_category')['name']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryToEdit);
            $entityManager->flush();

            $this->addFlash('category_deleted', 'Category successfully Edited!');

            return $this->redirectToRoute('categories');

        }

        return $this->render('admin/edit-category.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/delete-category/{id}", name="delete_category")
     */
    Public function deleteCategory(Category $category)

    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('category_deleted', 'Category successfully Deleted!');

        return $this->redirectToRoute('categories');

    }
}
