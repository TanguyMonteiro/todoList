<?php

namespace App\Controller;

use App\Entity\Check;
use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\CheckRepository;
use App\Repository\TodoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/{_locale}")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     * @Route("/todo/{param}", name="todo_sorted")
     */
    public function index(UserInterface $user , TodoRepository $repository , $param = null , PaginatorInterface $paginator , Request $requete): Response
    {


    $todos = $user->getTodos();

    if($param == "mostRecent"){

        $todos = $repository->findByUserSortedByMostRecent($user);
    }
    if($param == "lassRecent"){

        $todos = $repository->findByUserSortedByLessRecent($user);
        }
    if ($param == "mostUrgent"){

        $todos = $repository->findByUserSortedByMostUrgent($user);
    }
    if($param == "leastUrgent"){
        $todos = $repository->findByUserSortedByLeastUrgent($user);
    }

        $todos = $paginator->paginate(
            $todos ,
            $requete->query->getInt('page', 1),
            5
        );

        return $this->render('todo/index.html.twig', [
            "lesTodos" => $todos,



        ]);
    }
    /**
     *
     *@Route("/todo/create" , name="create_todo" , priority=1)
     */
    public function create(Request $requete , EntityManagerInterface $manager , UserInterface $user): Response
    {
        $todo = new Todo();
        $formulaire = $this->createForm(TodoType::class, $todo);

        $formulaire->handleRequest($requete);

        if ($formulaire->isSubmitted()) {
            $todo->setUser($user);
            $todo->setCreatedAt(new \DateTime());
            $manager->persist($todo);
            $manager->flush();
            return $this->redirectToRoute('todo');
        }
        return $this->render('todo/create.html.twig', [
            'form' => $formulaire->createView()
        ]);
    }

        /**
             * @Route("/delete/{id}" , name="delete_todo", requirements={"id":"\d+"})
         */
        public function delete(Todo $todo , EntityManagerInterface $manager , UserInterface $user)
    {
        if($user == $todo->getUser())
        {
            $manager->remove($todo);
            $manager->flush();

        }
            return $this->redirectToRoute('todo');
        }

        /**
         * @Route("/check/todo/{id}" , name="check_todo")
         *
         */
        public function check(EntityManagerInterface $manager , Todo $todo , CheckRepository $checkRepo )
        {
            if(!$todo->getChecked()){
                $check = new Check();

                $check->setTodo($todo);
                $check->setUser($todo->getUser());

                $manager->persist($check);
                $message = "checked";
            } else{

                $manager->remove($todo->getChecked());
                $message = "unchecked";
            }



            $manager->flush();


            $donnees = [
                'message'=> $message ,
                'nombreDeChecks' => $checkRepo->count(['user'=> $todo->getUser()])
            ];
            return $this->json($donnees , 200);
           // return $this->redirectToRoute('todo');
        }


}
