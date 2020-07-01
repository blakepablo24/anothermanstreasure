<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\FreeItemPictures;
use App\Form\NewFreeItemType;
use App\Form\NewFreePictureItemType;
use App\Form\EditFreeItemType;
use App\Form\AddNewCategoryType;
use App\Form\EditCategoryType;
// Image uploads and removals
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

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
     * @Route("/post-free-item", name="post_free_item", methods={"GET","POST"})
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

                $this->uploadFreeItemPicture($picture01, $freeItem, $slugger);

            }

            $picture02 = $form->get('picture02')->getData();
            
            if ($picture02) {

                $this->uploadFreeItemPicture($picture02, $freeItem, $slugger);

            }

            $picture03 = $form->get('picture03')->getData();
            
            if ($picture03) {

                $this->uploadFreeItemPicture($picture03, $freeItem, $slugger);

            }

            $picture04 = $form->get('picture04')->getData();
            
            if ($picture04) {
                
                $this->uploadFreeItemPicture($picture04, $freeItem, $slugger);

            }

            $picture05 = $form->get('picture05')->getData();
            
            if ($picture05) {
                
                $this->uploadFreeItemPicture($picture05, $freeItem, $slugger);

            }

            $picture06 = $form->get('picture06')->getData();
            
            if ($picture06) {
                
                $this->uploadFreeItemPicture($picture06, $freeItem, $slugger);

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
     * @Route("/edit-free-item/{id}", name="edit_free_item", methods={"GET","POST"})
     */
    public function editFreeItem(FreeItem $freeItem, Request $request, SluggerInterface $slugger)

    {

        $form_pic = $this->createForm(NewFreePictureItemType::class);
        $form_pic->handleRequest($request);

        if($form_pic->isSubmitted() && $form_pic->isValid())
        
        {

            $picture = $form_pic->get('newFreeItemPicture')->getData();
            
            if ($picture) {
                
                $this->uploadFreeItemPicture($picture, $freeItem, $slugger);

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('free_item_updated', 'Free Item successfully Updated!');

            return $this->redirectToRoute('edit_free_item', ['id' => $freeItem->getId()]);

        }

        $freeItem = $this->getDoctrine()->getRepository(FreeItem::class)->find($freeItem);

        $form = $this->createForm(EditFreeItemType::class, $freeItem);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $freeItem->setTitle($request->request->get('edit_free_item')['title']);
            $freeItem->setDescription($request->request->get('edit_free_item')['description']);

            $category = $request->request->get('edit_free_item')['category'];
            $repository = $this->getDoctrine()->getManager()->getRepository(Category::class);
            $category = $repository->find($category);
            $freeItem->setCategory($category);
            
            $freeItem->setLocation($request->request->get('edit_free_item')['location']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($freeItem);
            $entityManager->flush();

            $this->addFlash('free_item_updated', 'Free Item successfully Updated!');

            return $this->redirectToRoute('edit_free_item', ['id' => $freeItem->getId()]);

        }

        return $this->render('admin/edit-free-item.html.twig', [
            'form' => $form->createView(),
            'form_pic' => $form_pic->createView(),
            'freeItem' => $freeItem
        ]);

    }

    /**
     * @Route("/delete-free-item/{id}", name="delete_free_item")
     */
    Public function deleteFreeItem(FreeItem $freeItem)

    {   
        // Look to see if the free item has any images

        $images = $this->getDoctrine()->getRepository(FreeItemPictures::class)->findAll($freeItem);

        // Loop through any images and delete each one where needed

        foreach ($images as $image) {

            $path=$this->getParameter('pictures_directory').'/'.$image->getName();
            $fs = new FileSystem();
            $fs->remove($path);

        }

        // Once pictures have been removed, finally remove the free item and any relates file names in free item pictures

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($freeItem);
        $entityManager->flush();

        $this->addFlash('free_item_deleted', 'Free Item successfully Deleted!');

        return $this->redirectToRoute('categories');

    }

    /**
     * @Route("/delete-free-item-picture/{id}", name="delete_free_item_picture")
     */
    Public function deleteFreeItemPicture(FreeItemPictures $freeItemPicture)

    {   

        // get id of free item for eventual redirect
        $freeItem = $freeItemPicture->getFreeItem();

        // Remove actual picture file

            $path=$this->getParameter('pictures_directory').'/'.$freeItemPicture->getName();
            $fs = new FileSystem();
            $fs->remove($path);


        // Once picture have been removed

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($freeItemPicture);
        $entityManager->flush();

        $this->addFlash('free_item_image_removed', 'Free Item successfully Removed!');

        return $this->redirectToRoute('edit_free_item', ['id' => $freeItem->getId()]);

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

    // Function to deal with picture uploads

    public function uploadFreeItemPicture($picture, $freeItem, $slugger) 
    
    {

        $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $picture->move(
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

}
