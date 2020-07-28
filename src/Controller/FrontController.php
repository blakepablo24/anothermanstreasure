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
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;

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
            
            // Welcome email
            
            $email = (new TemplatedEmail())
            ->from('info@32collect.djbagsofun.co.uk')
            ->to($request->request->get('user')['email'])
            ->subject('Welcome to 32collect')
            ->htmlTemplate('emails/welcome_email.html.twig')
            ->context([
                'name' => $request->request->get('user')['name']
            ]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
            $sentEmail = $mailer->send($email);

            $this->loginUserAutomatically($user, $password);

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
     * @Route("/free-item-list-user/{id}", methods={"GET"}, name="free_item_list_user")
     */
    public function freeItemlistUser(User $user, Request $request)

    {

        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy(['user' => $user], ['date' => 'DESC', 'time' => 'DESC'], 8);

        return $this->render('front/free-item-list-user.html.twig', [
            'user' => $user,
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
    public function freeItemSingle(FreeItem $freeItem, Request $request, MailerInterface $mailer)

    {

        return $this->render('front/free-item-single.html.twig', [
            'freeItem' => $freeItem
        ]);

    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {

        
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
        'form' => $form->createView()
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
        $freeItems = $this->getDoctrine()->getRepository(FreeItem::class)->findBy([], ['date' => 'DESC', 'time' => 'DESC'], 5);

        return $this->render('front/includes/_free-items.html.twig', [
            'freeItems' => $freeItems
        ]);

    }

    private function prepareQuery(string $query): array

    {

        return explode(' ', $query);

    }

}
