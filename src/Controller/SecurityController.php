<?php
/**
 * this is the name space
 */
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

/**
 * this is the security controller
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends Controller
{

    /**
     * this looks after the login requests
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $template = 'security/login.html.twig';
        $args = [
            'last_username' => $lastUsername,
            'error'         => $error,
        ];

        return $this->render($template, $args);
    }
}
