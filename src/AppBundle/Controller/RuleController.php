<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class RuleController extends Controller
{

    public function lastAction()
    {
        return $this->render('AppBundle:Deck:top.html.twig', array(
        ));
    }

    public function toprateAction()
    {
        return $this->render('AppBundle:Deck:top.html.twig', array(
        ));
    }

    /**
     * @Route("/json/rules/smallList/{id}", name="rulesSmallListJson", requirements={"id": "\d+"})
     */
    public function jsonSmallListAction($id)
    {
        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Rule');
        $deck = $deckRepository->smallListByDeck($id);

        $response = new Response();
        $response->setContent($this->get('jms_serializer')->serialize($deck, 'json'));
        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('access-control-allow-origin', '*');
        return $response;
    }

    /**
     * @Route("/json/rules/list/{id}", name="rulesListJson", requirements={"id": "\d+"})
     */
    public function jsonListAction($id)
    {
        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Rule');
        $deck = $deckRepository->listByDeck($id);

        $response = new Response();
        $response->setContent($this->get('jms_serializer')->serialize($deck, 'json'));
        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('access-control-allow-origin', '*');
        return $response;
    }
}
