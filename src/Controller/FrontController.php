<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\FreeItem;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Service\ItemLocations;

class FrontController extends AbstractController
{

    /**
     * @Route("/", name="main_page")
     */
    public function index(ItemLocations $itemLocations)

    {

        $allLocations = $itemLocations->locations();

        $location = $this->get('session')->get('location');

        if ($location) 
        {
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy(['location' => $location], ['date' => 'DESC', 'time' => 'DESC'], 5);
        }
        else
        {
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy([], ['date' => 'DESC', 'time' => 'DESC'], 5);
        }

        return $this->render('front/index.html.twig', [
        'freeItems' => $freeItems,
        'allLocations' => $allLocations]);
    }

    /**
     * @Route("/free-item-lis-all", name="free_item_list_all")
     */
    public function freeItemListAll(ItemLocations $itemLocations)

    {

        $allLocations = $itemLocations->locations();

        $location = $this->get('session')->get('location');

        if ($location) 
        {
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy(['location' => $location], ['date' => 'DESC', 'time' => 'DESC']);
        }
        else
        {
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy([], ['date' => 'DESC', 'time' => 'DESC']);
        }

        return $this->render('front/free-item-list-all.html.twig', [
        'freeItems' => $freeItems,
        'allLocations' => $allLocations]);
    }

    /**
     * @Route("/user-selected-location", name="user_selected_location", methods={"GET"})
     */

    public function userSelectedLocation(Request $request)
    {

        $userSelectedLocation = $request->get('myLocation');
        
        $session = $this->get('session');

        $session->set('location', $userSelectedLocation);

        return $this->redirectToRoute('all_categories');

    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $helper)
    {

        return $this->render('front/login.html.twig', [
            'error' => $helper->getLastAuthenticationError()
        ]);

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/sign-up", name="sign_up")
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $password_encoder, MailerInterface $mailer)
    {

        $user = new User;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {
            
            $user->setName($request->request->get('user')['name']);
            $user->setLastName($request->request->get('user')['last_name']);
            $user->setEmail($request->request->get('user')['email']);
            
            $password = $password_encoder->encodePassword($user, 
            $request->request->get('user')['password']['first']);
            $user->setPassword($password);

            $user->setRoles(['ROLE_USER']);

            $user->setTotalFreeAds(0);
            $user->setStartDate(new \DateTime());
            $user->setStartTime(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->loginUserAutomatically($user, $password);

            // Welcome email
            
            $email = (new TemplatedEmail())
            ->from('no-reply@32collect.djbagsofun.co.uk')
            ->to($user->getEmail())
            ->subject('Welcome to 32collect')
            ->htmlTemplate('emails/welcome_email.html.twig')
            ->context([
                'name' => $user->getName()
            ]);

            /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
            $sentEmail = $mailer->send($email);

            return $this->redirectToRoute('admin_main_page');

        }

        return $this->render('front/sign-up.html.twig', [
            'form' => $form->createView()
        ]);

    }

    private function loginUserAutomatically($user, $password)

    {

        $token = new UsernamePasswordToken(
            $user,
            $password,
            'main',
            $user->getRoles()
        );

        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

    }

    /**
     * @Route("/all-categories", name="all_categories")
     */
    public function allCategories(ItemLocations $itemLocations)

    {
        $allLocations = $itemLocations->locations();

        return $this->render('front/all-categories.html.twig', [
            'allLocations' => $allLocations
        ]);

    }

    /**
     * @Route("/free-item-list-category/category/{categoryname},{id}", methods={"GET"}, name="free_item_list_category")
     */
    public function freeItemListCategory(ItemLocations $itemLocations, Category $category, Request $request)

    {
        $allLocations = $itemLocations->locations();

        $location = $this->get('session')->get('location');

        if ($location) 
        {
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy(['location' => $location,'category' => $category], ['date' => 'DESC', 'time' => 'DESC']);
        }
        else
        {
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy([], ['date' => 'DESC', 'time' => 'DESC'], 5);
        }

        return $this->render('front/free-item-list-category.html.twig', [
            'category' => $category,
            'freeItems' => $freeItems,
            'allLocations' => $allLocations
        ]);

    }

    /**
     * @Route("/free-item-list-user/{id}", methods={"GET"}, name="free_item_list_user")
     */
    public function freeItemlistUser(ItemLocations $itemLocations, User $user, Request $request)

    {
        $allLocations = $itemLocations->locations();

        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy(['user' => $user], ['date' => 'DESC', 'time' => 'DESC'], 8);

        return $this->render('front/free-item-list-user.html.twig', [
            'user' => $user,
            'freeItems' => $freeItems,
            'allLocations' => $allLocations
        ]);

    }

    /**
     *  @Route("/search-results", methods={"GET"}, name="search_results")
     */
    public function searchResults(ItemLocations $itemLocations, Request $request)

    {
        $allLocations = $itemLocations->locations();

        $data = $request->get('search');

        $location = $this->get('session')->get('location');

        if ($location) 
        {
            $results = $this->getDoctrine()->getRepository(FreeItem::class)->findSearchResultsWithLocation($data, $location);

        }
        else
        {

            $results = $this->getDoctrine()->getRepository(FreeItem::class)->findSearchResults($data);

        }

        return $this->render('front/search-results.html.twig', [
            'freeItems' => $results,
            'searchTerm' => $data,
            'allLocations' => $allLocations
        ]);

    }

    /**
     * @Route("/free-item-single/{id}", name="free_item_single", methods={"GET"})
     */
    public function freeItemSingle(ItemLocations $itemLocations, FreeItem $freeItem, Request $request, MailerInterface $mailer)

    {
        $allLocations = $itemLocations->locations();

        return $this->render('front/free-item-single.html.twig', [
            'freeItem' => $freeItem,
            'allLocations' => $allLocations
        ]);

    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(ItemLocations $itemLocations, Request $request, MailerInterface $mailer)
    {

        $allLocations = $itemLocations->locations();
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        
        {

            $formData = $form->getData();

            $email = (new TemplatedEmail())
            ->from($formData['email'])
            ->to('info@32collect.djbagsofun.co.uk')
            ->subject('New Message')
            ->htmlTemplate('emails/contact_form.html.twig')
            ->context([
                'name' => $formData['name'],
                'senders_email' => $formData['email'],
                'message' => $formData['message']
            ]);

            /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
            $sentEmail = $mailer->send($email);
            
            $this->addFlash('message_sent', 'Thank you for your message. It has successfully been sent');

            return $this->redirectToRoute('contact');

        }

        return $this->render('front/contact.html.twig', [
        'form' => $form->createView(),
        'allLocations' => $allLocations
        ]);
    }

    /**
     * @Route("/reuse-tips", name="reuse_tips")
     */
    public function reuseTips(ItemLocations $itemLocations)
    {
        $allLocations = $itemLocations->locations();

        return $this->render('front/reuse-tips.html.twig', [
            'allLocations' => $allLocations
        ]);

    }

    public function categories()

    {   

        $location = $this->get('session')->get('location');

        if ($location) 
        {
            
            $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findFreeItemsInLocation($location);

            $categories = [];

            foreach ($freeItems as $freeItem) {
                
                if (!in_array($freeItem->getCategory(), $categories)) {
                    array_push($categories, $freeItem->getCategory());
                }
            }

        }
        else
        {

            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        }

        return $this->render('front/includes/_categories.html.twig', [
            'categories' => $categories
        ]);

    }

    private function prepareQuery(string $query): array

    {

        return explode(' ', $query);

    }
}
