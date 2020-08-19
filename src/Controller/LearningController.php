<?php

namespace App\Controller;


use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Extension\AbstractExtension;

class LearningController extends AbstractController
{
    /**
     * @Route("/about-me", name="aboutme")
     * @param SessionInterface $session
     * @return Response
     */
    public function aboutMe(SessionInterface $session): response
    {
        if ($session->get('name')) {
            $name = $session->get('name');
            $date = new DateTime();
            return $this->render('aboutMe.html.twig', ['name' => $name, 'date' => $date]);
        }
            return $this->forward('App\Controller\LearningController::showMyName');
    }
    
    /**
     * @Route("/", name="showMyName")
     * @param SessionInterface $session
     * @return Response
     */
    public function showMyName(SessionInterface $session): response
    {
        if($session->get('name')){
            $name = $session->get('name');
        }else{
            $name = 'unknown';
        }

        return $this->render('showMyName.html.twig', [
        'name' => $name,]);
    }

    /**
     * @Route("/changeMyName", name="changeMyName", methods={"POST"})
     * @return RedirectResponse
     * @param Request $request
     * @param SessionInterface $session
     */

    public function changeMyName(Request $request, SessionInterface $session): RedirectResponse
    {
        $name = $request->request->get('name');
        $session->set('name', $name);

        return $this->redirectToRoute('showMyName');
     }
}

