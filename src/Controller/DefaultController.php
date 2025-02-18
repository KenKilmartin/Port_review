<?php
/**
 * this is the name space
 */
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


use App\Entity\Port;


/**
 * this is the default controller
 * Class DefaultController
 * @package App\Controller
 */

class DefaultController extends Controller
{
    /**
     * this looks after the first page of the whole site
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $template = 'default/homepage.html.twig';
        $args = [];

        $ports = $this->getDoctrine()
            ->getRepository(Port::class)
            ->findAll();
        return $this->render('default/homepage.html.twig', ['ports' => $ports]);
    }
}
