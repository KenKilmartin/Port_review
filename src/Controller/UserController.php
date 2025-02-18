<?php
/**
 * This is for sake of doc
 */
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is the user controller
 * Class UserController
 * @package App\Controller
 * @Route("/user", name="user_")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', ['users' => $users]);
    }

    /**
     * this is to make a new user
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage', ['id' => $user->getId()]);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * this is to show a new user
     * @Route("/{id}", name="show")
     * @Method("GET")
     */
    public function show(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * this is to edit a new user
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * this is to delete a new user
     * @Route("/{id}", name="delete")
     * @Method("DELETE")
     */
    public function delete(Request $request, User $user)
    {
        if (!$this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('user_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }
}
