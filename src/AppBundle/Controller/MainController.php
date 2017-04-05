<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/~vrasquie/cas/auth", name="auth")
     */
    public function authAction()
    {
        return $this->render('actions/close.html.twig');
    }

    /**
     * @Route("/~vrasquie/cas/token", name="token")
     */
    public function tokenAction()
    {
        $casUser = $this->getUser();
        
        if (!$casUser) {
            
        }

        $userService = $this->get("user.service");
        $user = $userService->getUserByUid($casUser->getUsername());

        $jwtService = $this->get("jwt.service");
        $token = $jwtService->generate($user);

        $response = array(
            "type" => $token ? "success" : "error",
            "token" => $token,
            "code" => $token ? 0 : 2
        );

        return new JsonResponse($response);
    }

    /**
     * @Route("/~vrasquie/cas/connect", name="connect")
     */
    public function connectAction()
    {
        return $this->render('actions/connect.html.twig', array(
            "connected" => $this->getUser() ? true : false
        ));
    }

    /**
     * @Route("/~vrasquie/cas/edt", name="edt")
     */
    public function edtAction(Request $request)
    {
        //https://edt.u-pem.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=1813,1806,1812,1811,1807,1640,5314&projectId=19&calType=ical&nbWeeks=4&sqlMode=true
    }
}
