<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     *
     */
    public function indexAction(Request $request)
    {
//        echo $this->getParameter('app.test');

//        $user = new \AppBundle\Entity\User();
//        $plainPassword = 'admin';
//        $encoder = $this->container->get('security.password_encoder');
//        $encoded = $encoder->encodePassword($user, $plainPassword);


        $x=$this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        /* @var $x \AppBundle\Entity\User[] */

        d($x[0]->serialize());

        $this->get('app.test')->test();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     *
     */
    public function adminAction()
    {
        $response = new Response('<p>This is an admin page!</p>');

        return $response;
    }

    /**
     *
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AppBundle:basic:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
}
