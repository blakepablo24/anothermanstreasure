<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\FreeItemPictures;
use App\Entity\User;
use App\Form\NewFreeItemType;
use App\Form\NewFreePictureItemType;
use App\Form\EditFreeItemType;
use App\Form\AddNewCategoryType;
use App\Form\EditCategoryType;
use App\Form\EditUserDetailsType;
// Image uploads and removals
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Service\ItemLocations;
use App\Entity\Locations;

/**
 * @Route("/admin")
*/

class AdminController extends AbstractController
{

    /**
     * @Route("/", name="admin_main_page")
     */
    public function index(ItemLocations $itemLocations)
    {

        $users = $this->getDoctrine()->getRepository(User::class)->findUsers();

        $numberOfUsers = count($users);

        $userAds = [];

            foreach ($users as $user) {
                
                    array_push($userAds, $user->getTotalFreeAds());

            }

            $allTimeAds = array_sum($userAds);

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findAll();

        $locations = $this->getDoctrine()->getRepository(Locations::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'freeItems' => $freeItems,
            'categories' => $categories,
            'users' => $users,
            'locations' => $locations,
            'allTimeAds' => $allTimeAds
        ]);
    }

    /**
     * @Route("/post-free-item", name="post_free_item", methods={"GET","POST"})
     */
    public function postFreeItem(Request $request, SluggerInterface $slugger, MailerInterface $mailer)

    {

        $user = $this->getUser();

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
            $freeItem->setState('Draft');
            $freeItem->setUser($user);
            $freeItem->setDate(new \DateTime());
            $freeItem->setTime(new \DateTime());

            $numberOfAds = $user->getTotalFreeAds() + 1;
            $user->setTotalFreeAds($numberOfAds);

            $locationsStat = $this->getDoctrine()->getManager()->getRepository(Locations::class)->findLocation($request->request->get('new_free_item')['location']);

            if($locationsStat)
            {
                $noOfAdsIncremented = $locationsStat->getTotalAds();
                $noOfLiveAdsIncremented = $locationsStat->getLiveAds();
                $locationsStat->setTotalAds($noOfAdsIncremented + 1);
                $locationsStat->setLiveAds($noOfLiveAdsIncremented + 1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($locationsStat);
            } 
            else 
            {
                $locationsStat = new Locations();
                $locationsStat->setLocation($request->request->get('new_free_item')['location']);
                $locationsStat->setTotalAds(1);
                $locationsStat->setLiveAds(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($locationsStat);
            }

            // Does it have any pictures attached to the free Item
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

            $this->addFlash('free_item_updated', 'New Image added successfully');

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

            return $this->redirectToRoute('free_item_single', ['id' => $freeItem->getId()]);

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

        $images = $freeItem->getFreeItemPictures();

        // Loop through any images and delete each one where needed

        foreach ($images as $image) {

            $path=$this->getParameter('pictures_directory').'/'.$image->getName();
            $fs = new FileSystem();
            $fs->remove($path);

        }

        $locationsStat = $this->getDoctrine()->getManager()->getRepository(Locations::class)->findLocation($freeItem->getLocation());
        $locationsStat->setLiveAds($locationsStat->getLiveAds() - 1);

        // Once pictures have been removed, finally remove the free item and any relates file names in free item pictures

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($locationsStat);
        $entityManager->remove($freeItem);
        $entityManager->flush();

        $this->addFlash('free_item_deleted', 'Free Item successfully Deleted!');

        return $this->redirectToRoute('admin_main_page');

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

        $this->addFlash('free_item_updated', 'Image successfully Removed!');

        return $this->redirectToRoute('edit_free_item', ['id' => $freeItem->getId()]);

    }

    // User Contact details

    /**
     * @Route("/edit-user-details/{id}", name="edit_user_details", methods={"GET","POST"})
     */
    public function editUserDetails(Request $request, User $user)

    {
        $userToEdit = $this->getDoctrine()->getRepository(User::class)->find($user);

        $form = $this->createForm(EditUserDetailsType::class, $userToEdit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $userToEdit->setEmail($request->request->get('edit_user_details')['email']);
            $userToEdit->setName($request->request->get('edit_user_details')['name']);
            $userToEdit->setLastName($request->request->get('edit_user_details')['last_name']);
            $userToEdit->setNumber($request->request->get('edit_user_details')['number']);
            $userToEdit->setAddressLine1($request->request->get('edit_user_details')['address_line_1']);
            $userToEdit->setAddressLine2($request->request->get('edit_user_details')['address_line_2']);
            $userToEdit->setAddressLine3($request->request->get('edit_user_details')['address_line_3']);
            $userToEdit->setAddressTown($request->request->get('edit_user_details')['address_town']);
            $userToEdit->setAddressCounty($request->request->get('edit_user_details')['address_county']);
            $userToEdit->setAddressPostCode($request->request->get('edit_user_details')['address_post_code']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userToEdit);
            $entityManager->flush();

            $this->addFlash('user_details_updated', 'Your details have been updated successfully');

            return $this->redirectToRoute('admin_main_page');

        }

        return $this->render('admin/edit-user-details.html.twig', [
            'form' => $form->createView()
        ]);

    }

    // Function to deal with picture uploads

    public function uploadFreeItemPicture($picture, $freeItem, $slugger) 
    
    {

        $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();
        
        $img = Image::make($picture)->orientate();

        try {
            $directory = $this->getParameter('pictures_directory');
            $img->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save(
                $directory.'/'.$newFilename.'.jpg'
            );    

        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        $freeItemPicture = new FreeItemPictures();

        $freeItemPicture->setName($newFilename.'.jpg');

        $freeItemPicture->setFreeItem($freeItem);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($freeItemPicture);

    }

// *******Super admin area*******

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

    /**
     * @Route("/users", name="users")
     */
    public function users()

    {
        $users = $this->getDoctrine()->getRepository(User::class)->findUsers();

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);

    }

    /**
     * @Route("/locations", name="locations")
     */
    public function locations()

    {

        $locations = $this->getDoctrine()->getRepository(Locations::class)->findBy([], ['totalAds' => 'DESC']);

        return $this->render('admin/locations.html.twig', [
            'locations' => $locations
        ]);

    }

}
