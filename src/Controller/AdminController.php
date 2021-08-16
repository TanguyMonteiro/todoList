<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('admin/index.html.twig', [
            "lesUsers" => $users,
        ]);
    }
        /**
         * @Route("/show/{id}", name="show_user")
         */
    public function show($id , User $user): Response
    {
        $todos = $user->getTodos();
        return $this->render('admin/show.html.twig', [
            "unUser" => $user ,
            "lesTodos" => $todos
    ]);
    }
    /**
     * @Route("/delete/user/{id}", name="admin_delete_user")
     */
    public function deleteUser(User $user , EntityManagerInterface $manager): Response{


    $manager->remove($user);
    $manager->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/delete/todo/{id}", name="admin_delete_todo")
     */
    public function deleteTodo(Todo $todo, EntityManagerInterface $manager): Response{
        $manager->remove($todo);
        $manager->flush();
        return $this->redirectToRoute('admin');
    }
}
