<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Form\DeckForm;

class DeckController extends Controller
{
    /**
     * @Route("/deck/new", name="NewDeck")
     */
    public function newAction()
    {
        return $this->render('AppBundle:Deck:new.html.twig', array(
        ));
    }

    /**
     * @Route("/deck/edit/{deckId}", name="EditDeck", requirements={"deckId": "\d+"})
     */
    public function editAction($deckId)
    {
        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Deck');
        $deck = $deckRepository->find($deckId);
        return $this->render('AppBundle:Deck:new.html.twig', array(
            'deck' => $deck
        ));
    }

    /**
     * @Route("/deck/create/rules", name="CreateRules")
     * Au Submit du new, on crée les rules et on redirige vers le form d'infos
     */
    public function createRulesAction(Request $request)
    {
        $session = $request->getSession();

        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        $simpleRuleType = $em->getRepository('AppBundle:Ruletype')->find(1);
        $multipleRuleType = $em->getRepository('AppBundle:Ruletype')->find(2);
        $serevalPartsRuleType = $em->getRepository('AppBundle:Ruletype')->find(3);

        //soit c'est un tout nouveau deck, soit c'est un deck nouveau à partir d'un existant, soit c'est un update
        if(isset($data['deckId']) && isset($data['mode']) && $data['mode'] == 'new') {
            //nouveau à partir d'un existant
            //donc faut créer un nouveau deck mais faire gaffe à pas créer les règles pas modifs
            //pour ce qui a été delete => osef
            
            $deck = new \AppBundle\Entity\Deck();
            $decktype = $em->getRepository('AppBundle:Decktype')->find($data['deckType']);
            $deck->setDecktype($decktype);
            $deck->setUser($this->getUser());

            if(!empty($data['updatedRules'])) 
                $updatedRules = explode(';', $data['updatedRules']);
            else
                $updatedRules = array();

            if (isset($data['simpleRules'])) {
                foreach ($data['simpleRules'] as $idsr => $sr) {
                    if(in_array($idsr, $updatedRules)) {
                        $rule = new \AppBundle\Entity\Rule();
                        $rule->setRuletype($simpleRuleType);
                        $rule->setUser($this->getUser());
                    }
                    else {
                        $rule = $em->getRepository('AppBundle:Rule')->find($idsr);
                    }
                    $text = $this->get('app.clean')->cleanRule($sr, 1);
                    $rule->setText($text);
                    
                    $deck->addRule($rule);            
                }
            }

            if (isset($data['multipleRules'])) {
                foreach ($data['multipleRules'] as $idmr => $mr) {
                    if(in_array($idmr, $updatedRules)) {
                        $rule = new \AppBundle\Entity\Rule();
                        $rule->setRuletype($multipleRuleType);
                        $rule->setUser($this->getUser());
                    }
                    else {
                        $rule = $em->getRepository('AppBundle:Rule')->find($idmr);
                    }
                    $text = $this->get('app.clean')->cleanRule($mr, 2);
                    $rule->setText($text);

                    $deck->addRule($rule); 
                }
            }

            if (isset($data['severalPartsRules'])) {
                foreach ($data['severalPartsRules'] as $idspr => $spr) {
                    if(in_array($idspr, $updatedRules)) {
                        $rule = new \AppBundle\Entity\Rule();
                        $rule->setRuletype($serevalPartsRuleType);
                        $rule->setUser($this->getUser());
                    }
                    else {
                        $rule = $em->getRepository('AppBundle:Rule')->find($idspr);
                    }
                    $text = $this->get('app.clean')->cleanRule($spr, 3);
                    $rule->setText($text);
                    
                    $deck->addRule($rule); 
                }
            }
        }
        else if(isset($data['deckId']) && isset($data['mode']) && $data['mode'] == 'update') {
            //update
            $deck = $em->getRepository('AppBundle:Deck')->find($data['deckId']);

            if($this->getUser() !== $deck->getUser())
                throw $this->createNotFoundException('Il est impossible de modifier un deck qui ne vous appartient pas !');

            if(!empty($data['updatedRules'])) {
                $updatedRules = explode(';', $data['updatedRules']);
                foreach ($updatedRules as $upr) {
                    $rule = $em->getRepository('AppBundle:Rule')->find($upr);
                    if(!empty($rule)){
                        if(isset($data['simpleRules'][$upr])) {
                            $rule->setRuletype($simpleRuleType);
                            $rule->setText($this->get('app.clean')->cleanRule($data['simpleRules'][$upr], 1));
                        }
                        if(isset($data['multipleRules'][$upr])) {
                            $rule->setRuletype($multipleRuleType);
                            $rule->setText($this->get('app.clean')->cleanRule($data['multipleRules'][$upr], 2));
                        }
                        if(isset($data['severalPartsRules'][$upr])) {
                            $rule->setRuletype($serevalPartsRuleType);
                            $rule->setText($this->get('app.clean')->cleanRule($data['severalPartsRules'][$upr], 3));
                        }
                        $em->persist($rule);
                        $em->flush();
                    }
                }
            }

            if(!empty($data['deletedRules'])) {
                $deletedRules = explode(';', $data['deletedRules']);
                foreach ($deletedRules as $dlr) {
                    $rule = $em->getRepository('AppBundle:Rule')->find($dlr);
                    if(!empty($rule))
                        $deck->removeRule($rule);
                }
            }

        }
        else {
            //un nouveau deck
            $deck = new \AppBundle\Entity\Deck();
            $decktype = $em->getRepository('AppBundle:Decktype')->find($data['deckType']);
            $deck->setDecktype($decktype);
            $deck->setUser($this->getUser());
        }

        //quelque soit la possibilité, update/create/createfromnew, si une règle n'existe pas elle est crée 
        if (isset($data['newSimpleRules'])) {
            foreach ($data['newSimpleRules'] as $sr) {
                $rule = new \AppBundle\Entity\Rule();
                $rule->setRuletype($simpleRuleType);
                $text = $this->get('app.clean')->cleanRule($sr, 1);
                $rule->setText($text);
                $rule->setUser($this->getUser());
                $deck->addRule($rule);            
            }
        }

        if (isset($data['newMultipleRules'])) {
            foreach ($data['newMultipleRules'] as $mr) {
                $rule = new \AppBundle\Entity\Rule();
                $rule->setRuletype($multipleRuleType);
                $text = $this->get('app.clean')->cleanRule($mr, 2);
                $rule->setText($text);
                $rule->setUser($this->getUser());
                $deck->addRule($rule); 
            }
        }

        if (isset($data['newSeveralPartsRules'])) {
            foreach ($data['newSeveralPartsRules'] as $spr) {
                $rule = new \AppBundle\Entity\Rule();
                $rule->setRuletype($serevalPartsRuleType);
                $text = $this->get('app.clean')->cleanRule($spr, 3);
                $rule->setText($text);
                $rule->setUser($this->getUser());
                $deck->addRule($rule); 
            }
        }

        $em->persist($deck);
        $em->flush();

        $session->set('deckId', $deck->getId());

        return $this->redirectToRoute('DeckInfos');

    }

    /**
     * @Route("/deck/infos", name="DeckInfos")
     */
    public function infosAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $deck = $em->getRepository('AppBundle:Deck')->find($session->get('deckId'));

        $form = $this->createForm(DeckForm::class, $deck);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $deck = $form->getData();

            $em->persist($deck);
            $em->flush();

            $session->getFlashBag()->add('success', 'Deck enregistré !');
        }

        return $this->render('AppBundle:Deck:infos.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/deck/list/{username}", name="deckListUser")
     */
    public function deckListUserAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Deck');

        $deckList = $deckRepository->listByUser($user);

        return $this->render('AppBundle:Deck:listUser.html.twig', array(
            'deckList' => $deckList
        ));
    }

    /**
     * @Route("/deck/list", name="deckList")
     */
    public function deckListAction()
    {
        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Deck');

        $deckList = $deckRepository->listAll();

        return $this->render('AppBundle:Deck:listUser.html.twig', array(
            'deckList' => $deckList
        ));
    }


    /**
     * @Route("/json/deck/list/{decktype}", name="deckListJson", requirements={"decktype": "\d+"})
     */
    public function jsonListAction($decktype)
    {
        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Deck');
        $deckList = $deckRepository->listByDecktype($decktype);
        
        $response = new Response();
        $response->setContent($this->get('jms_serializer')->serialize($deckList, 'json'));
        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('access-control-allow-origin', '*');
        return $response;
    }

    /**
     * @Route("/json/deck/{id}", name="deckJson", requirements={"id": "\d+"})
     */
    public function jsonAction($id)
    {
        $deckRepository = $this->getDoctrine()->getRepository('AppBundle:Deck');
        $deck = $deckRepository->oneDeck($id);

        $response = new Response();
        $response->setContent($this->get('jms_serializer')->serialize($deck, 'json'));
        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('access-control-allow-origin', '*');
        return $response;
    }

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

}
