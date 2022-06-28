<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Tickspots;
use Zibios\WrikePhpSdk\ApiFactory;
use Zibios\WrikePhpLibrary\Api;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Vacations;
use App\Form\VacationType;
use App\Entity\Ideas;
use App\Entity\Tickspot;
use App\Entity\TimeTracking;
use App\Form\UserEditType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    private $menus = [
        'admin' => [
            'title' => 'Пользователи',
            'url' => '/admin'
        ],
        'time-tracking' => [
            'title' => 'Учет времени',
            'url' => '/admin/time-tracking'
        ],
        'worklogs' => [
            'title' => 'Ворклоги',
            'url' => '/admin/worklogs'
        ],
        'vacation' => [
            'title' => 'Отпуска',
            'url' => '/admin/vacation'
        ],
        'grades' => [
            'title' => 'Грейды',
            'url' => '/admin/grades'
        ],
        'metrics' => [
            'title' => 'Метрики',
            'url' => '/admin/metrics'
        ],
        'ideas' => [
            'title' => 'Идеи',
            'url' => '/admin/ideas'
        ],
    ];
    
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'admin',
            'users' => $users
        ]);
    }
    
    /**
     * @Route("/admin/add-user", name="app_admin_add_user")
     */
    public function addUser(Request $request): Response
    {
        $user = $this->getUser();
        $username = $user->getName();        
        $users = new User();
        $form = $this->createForm(UserType::class, $users);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {         
            $em = $this->getDoctrine()->getManager();
            $plainpwd = $users->getPassword();
            $encoded = $this->passwordEncoder->encodePassword($users, $plainpwd);
            $users->setPassword($encoded);
            $em->persist($users);
            $em->flush();
            return $this->redirectToRoute('app_admin');
        }
        
        return $this->render('admin/add-user.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'admin',
            'form' => $form->createView()
        ]);
    }
    
     /**
     * @Route("/admin/edit-user/{id}", name="app_admin_edit_user")
     */
    public function editUser(Request $request, int $id): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserEditType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $plainpwd = $users->getPassword();
            $encoded = $this->passwordEncoder->encodePassword($users, $plainpwd);
            $users->setPassword($encoded);
            $em->flush();
            return $this->redirectToRoute('app_admin');
        }
        
        return $this->render('admin/edit-user.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'admin',
            'form' => $form->createView()
        ]);
    }
    
     /**
     * @Route("/admin/time-tracking", name="app_admin_time_tracking")
     */
    public function timeTracking(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();        
        $timetrackings = $this->getDoctrine()->getRepository(TimeTracking::class)->findAll();
        
        //$api = ApiFactory::create('eyJ0dCI6InAiLCJhbGciOiJIUzI1NiIsInR2IjoiMSJ9.eyJkIjoie1wiYVwiOjU1NjExNzksXCJpXCI6MjA1MTAsXCJjXCI6NDYwMDk1NixcInVcIjoxMzM3Njg2NSxcInJcIjpcIlVTMlwiLFwic1wiOltcIldcIixcIkZcIixcIklcIixcIlVcIixcIktcIixcIkNcIixcIkRcIixcIk1cIixcIkFcIixcIkxcIixcIlBcIl0sXCJ6XCI6W10sXCJ0XCI6MH0iLCJpYXQiOjE2NTYyNzYyMTd9.8sgi4AxLxdxl65-UBrDlY6yeyXmnHR3uSFLhzGSZLq0');
//$allContacts = $api->account()->getAll();
        //$api = new Api('eyJ0dCI6InAiLCJhbGciOiJIUzI1NiIsInR2IjoiMSJ9.eyJkIjoie1wiYVwiOjU1NjExNzksXCJpXCI6MjA1MTAsXCJjXCI6NDYwMDk1NixcInVcIjoxMzM3Njg2NSxcInJcIjpcIlVTMlwiLFwic1wiOltcIldcIixcIkZcIixcIklcIixcIlVcIixcIktcIixcIkNcIixcIkRcIixcIk1cIixcIkFcIixcIkxcIixcIlBcIl0sXCJ6XCI6W10sXCJ0XCI6MH0iLCJpYXQiOjE2NTYyNzYyMTd9.8sgi4AxLxdxl65-UBrDlY6yeyXmnHR3uSFLhzGSZLq0');
        //$wrike = ApiFactory::create('eyJ0dCI6InAiLCJhbGciOiJIUzI1NiIsInR2IjoiMSJ9.eyJkIjoie1wiYVwiOjU1NjExNzksXCJpXCI6MjA1MTAsXCJjXCI6NDYwMDk1NixcInVcIjoxMzM3Njg2NSxcInJcIjpcIlVTMlwiLFwic1wiOltcIldcIixcIkZcIixcIklcIixcIlVcIixcIktcIixcIkNcIixcIkRcIixcIk1cIixcIkFcIixcIkxcIixcIlBcIl0sXCJ6XCI6W10sXCJ0XCI6MH0iLCJpYXQiOjE2NTYyNzYyMTd9.8sgi4AxLxdxl65-UBrDlY6yeyXmnHR3uSFLhzGSZLq0');
       // dump($api->getAccountResource()->getAll());
        return $this->render('admin/time-tracking.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'time-tracking',
            'timetrackings' => $timetrackings
        ]);
    }
    
     /**
     * @Route("/admin/load-time-tracking", name="app_admin_load_time_tracking")
     */
    public function loadTimeTracking(): Response
    {
        $result = false;
        $message = '';
        $tickspots = new Tickspots(['token' => 'a06642cf49e1b58db3895f4e727abaa3', 'email' => 'matusevica74@gmail.com', 'subscription' => '142239']);
        $user_json = $tickspots->getUsers();
        if(!empty($user_json))
        {
            $users = json_decode($user_json);
            if(!empty($users))
            {
                foreach ($users as $val)
                {
                    $em = $this->getDoctrine()->getManager();
                    $tickspot = $em->getRepository(Tickspot::class)->findBy(array('uid' => $val->id));
                    if(empty($tickspot))
                    {
                        $tickspot = new Tickspot();
                        $tickspot->setUid($val->id);
                        $tickspot->setFirstName($val->first_name);
                        $tickspot->setLastName($val->last_name);
                        $tickspot->setEmail($val->email);
                        $em->persist($tickspot);
                        $em->flush();
                        $result = true;
                    }
                    $date_max_res = $em->getRepository(TimeTracking::class)->findByMaxUpdatedAt();
                    $date_max_start = new \DateTime();
                    $date_max_end = new \DateTime();
                    if(!empty($date_max_res) && !empty($date_max_res[0]['date_max']))
                    {
                        $date_max_start = new \DateTime($date_max_res[0]['date_max']);
                        $date_max_start->modify("+1 hour");
                    }

                    $entrie_json = $tickspots->getEntries(null, $date_max_start->format('Y-m-d\TH:i:s.'), $date_max_end->format('Y-m-d\TH:i:s.'), null, null, $val->id, null);
                    if(!empty($entrie_json))
                    {
                        $entries = json_decode($entrie_json);
                        if(!empty($entries))
                        {
                            foreach ($entries as $val)
                            {
                                $task_json = $tickspots->getUserDetails($val->task_id);
                                if(!empty($task_json))
                                {
                                    $task = json_decode($task_json);
                                    if(!empty($task))
                                    {
                                        $time_tracking_uid = $em->getRepository(TimeTracking::class)->findBy(array('uid' => $val->id));
                                        if(!empty($time_tracking_uid) && !empty($time_tracking_uid[0]) && !empty($time_tracking_uid[0]->getId()))
                                        {
                                            $time_tracking = $em->getRepository(TimeTracking::class)->find($time_tracking_uid[0]->getId());
                                            $time_tracking->setHours($val->hours);
                                            $time_tracking->setNotes($val->notes);
                                            $time_tracking->setTask($task->name);
                                            $entrie_updated_at = new \DateTime($val->updated_at);
                                            $time_tracking->setUpdatedAt($entrie_updated_at);
                                        }
                                        else 
                                        {
                                            $time_tracking = new TimeTracking();
                                            $time_tracking->setDate($val->date);
                                            $time_tracking->setUserId($val->user_id);
                                            $time_tracking->setUrl($val->url);
                                            $time_tracking->setUid($val->id);
                                            $entrie_created_at = new \DateTime($val->created_at);
                                            $time_tracking->setCreatedAt($entrie_created_at);
                                            $time_tracking->setHours($val->hours);
                                            $time_tracking->setNotes($val->notes);
                                            $time_tracking->setTask($task->name);
                                            $entrie_updated_at = new \DateTime($val->updated_at);
                                            $time_tracking->setUpdatedAt($entrie_updated_at);
                                            $em->persist($time_tracking);
                                        }
                                        $em->flush();
                                        $result = true;
                                    }
                                }
                            }
                        }
                    }
                }
                if($result)
                {
                    $message = 'Данных загружены';
                }
                else
                {
                    $message = 'Данные уже загружены';
                }
            }
            else
            {
                $result = false;
                $message = 'Ошибка обработки данных';
            }
        }
        else
        {
            $result = true;
            $message = 'Данных нет';
        }
        
        $response = new Response();
        $response->setContent(json_encode([
            'success' => $result,
            'message' => $message
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
     /**
     * @Route("/admin/worklogs", name="app_admin_worklogs")
     */
    public function worklogs(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        return $this->render('admin/worklogs.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'worklogs'
        ]);
    }
    
     /**
     * @Route("/admin/vacation", name="app_admin_vacation")
     */
    public function vacation(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        $vacations = $this->getDoctrine()->getRepository(Vacations::class)->findAll();
        return $this->render('admin/vacation.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'vacation',
            'vacations' => $vacations
        ]);
    }
    
     /**
     * @Route("/admin/add-vacation", name="app_admin_add_vacation")
     */
    public function addVacation(Request $request): Response
    {
        $user = $this->getUser();
        $username = $user->getName();        
        $vacation = new Vacations();
        $form = $this->createForm(VacationType::class, $vacation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {            
            $em = $this->getDoctrine()->getManager();
            $em->persist($vacation);
            $em->flush();
            return $this->redirectToRoute('app_admin_vacation');
        }
        
        return $this->render('admin/add-vacation.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'vacation',
            'form' => $form->createView()
        ]);
    }
    
     /**
     * @Route("/admin/edit-vacation/{id}", name="app_admin_edit_vacation")
     */
    public function editVacation(Request $request, int $id): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        $em = $this->getDoctrine()->getManager();
        $vacation = $em->getRepository(Vacations::class)->find($id);
        $form = $this->createForm(VacationType::class, $vacation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em->flush();
            return $this->redirectToRoute('app_admin_vacation');
        }
        
        return $this->render('admin/edit-vacation.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'vacation',
            'form' => $form->createView()
        ]);
    }
    
     /**
     * @Route("/admin/grades", name="app_admin_grades")
     */
    public function grades(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        return $this->render('admin/grades.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'grades'
        ]);
    }
    
     /**
     * @Route("/admin/metrics", name="app_admin_metrics")
     */
    public function metrics(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        return $this->render('admin/metrics.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'metrics'
        ]);
    }
    
     /**
     * @Route("/admin/ideas", name="app_admin_ideas")
     */
    public function ideas(): Response
    {
        $user = $this->getUser();
        $username = $user->getName();
        $ideas = $this->getDoctrine()->getRepository(Ideas::class)->findAll();
        return $this->render('admin/ideas.html.twig', [
            'username' => $username,
            'menus' => $this->menus,
            'active' => 'ideas',
            'ideas' => $ideas
        ]);
    }
}
