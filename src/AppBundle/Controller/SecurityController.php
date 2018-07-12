<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;


class SecurityController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function tbLoginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $data =  array(
            'last_username' => $lastUsername,
            'csrf_token' => $csrfToken,
        );
        return $this->container->get('templating')->renderResponse('AppBundle:Security:tbLogin.html.twig', $data);
    }

    /**
     * For internal template use: Renders the Dropdown after authentication ej. Header bar for user.
     * No routing used.
     */
    public function tbAuthenticatedAction()
    {
        $data =  array();
        return $this->container->get('templating')
            ->renderResponse('AppBundle:Security:tbAuthenticated.html.twig', $data);
    }
}
?>