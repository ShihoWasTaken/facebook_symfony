<?php

namespace TechCorp\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StaticController extends Controller
{
    public function homepageAction()
    {
		return $this->render(
			'TechCorpFrontBundle:Static:homepage.html.twig'
		);
    }

    public function aboutAction()
	{
		return $this->render('TechCorpFrontBundle:Static:about.html.twig');
	}
}
