<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    /**
     * @param $count
     * @return Response
     */
    public function numberAction($count)
    {
        $numbers = [];

        for($i = 0; $i < $count; $i++) {
            $numbers[] = rand(0, 100);
        }

        $numbersList = implode(', ', $numbers);


        $expr   = new ExpressionLanguage();
        $result = $expr->evaluate('1+2');



        // doctrine
        $repo     = $this->getDoctrine()->getRepository('AppBundle:Product');
        $products = $repo->findAllOrderedByName();

        // render: a shortcut that does the same as above
        return $this->render(
            'AppBundle:lucky:number.html.twig',
            [
                'luckyNumberList' => $numbersList,
                'result'          => $result,
            ]
        );
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction()
    {
        $data = [
            'lucky_number' => rand(0, 100),
        ];

        return new JsonResponse($data);
    }

    public function asyncAction()
    {
        return $this->render(
            'AppBundle:lucky:async.html.twig'
        );
    }
}