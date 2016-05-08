<?php
namespace TechCorp\FrontBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TechCorp\FrontBundle\Entity\Status;
use TechCorp\FrontBundle\Form\StatusType;

class TimelineController extends Controller
{
	public function timelineAction()
	{
		$em = $this->getDoctrine()->getManager();

        //$authenticatedUser = $this->get('security.context')->getToken()->getUser();
        $authenticatedUser = $this->getUser();

        $status = new Status();
        $status->setDeleted(false);

        $status->setUser($authenticatedUser);
        $form = $this->createForm(new StatusType(), $status);
        $request = $this->getRequest();
        $form->handleRequest($request);

        // 3) Traiter le formulaire
        if ($authenticatedUser && $form->isValid()) {
            $em->persist($status);
            $em->flush();
            $this->redirect($this->generateUrl(
                'tech_corp_front_user_timeline', array(
                'userId' => $authenticatedUser->getId()
            ))
            );
        }
        $statuses = $em->getRepository('TechCorpFrontBundle:Status')->findAll();

		return $this->render('TechCorpFrontBundle:Timeline:timeline.html.twig',
			array(
				'statuses' => $statuses,
                'user' => $authenticatedUser,
                'form' => $form->createView(),
			));
	}

	public function userTimelineAction($userId)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('TechCorpFrontBundle:User')->findOneById($userId);

		if (!$user)
		{
			$this->createNotFoundException("L'utilisateur n'a pas été trouvé.");
		}
                
                //$authenticatedUser = $this->get('security.context')->getToken()->getUser();
                $authenticatedUser = $this->getUser();
                $status = new Status();
                $status->setDeleted(false);
                
                $status->setUser($authenticatedUser);
                $form = $this->createForm(new StatusType(), $status);
                $request = $this->getRequest();
                $form->handleRequest($request);
                
                // 3) Traiter le formulaire
                if ($authenticatedUser && $form->isValid()) {
                    $em->persist($status);
                    $em->flush();
                    $this->redirect($this->generateUrl(
                        'tech_corp_front_user_timeline', array(
                            'userId' => $authenticatedUser->getId()
                        ))
                    );
                }
                
		$statuses = $em->getRepository ('TechCorpFrontBundle:Status')->getUserTimeline($user)->getResult();
		
		return $this->render ('TechCorpFrontBundle:Timeline:user_timeline.html.twig',
			array(
					'user' => $user,
					'statuses' => $statuses,
                                        'form' => $form->createView(),
			)
		);
	}
        
        public function friendsTimelineAction()
        {
            $em = $this->getDoctrine()->getManager();

            //$authenticatedUser = $this->get('security.context')->getToken()->getUser();
            $authenticatedUser = $this->getUser();

            $status = new Status();
            $status->setDeleted(false);

            $status->setUser($authenticatedUser);
            $form = $this->createForm(new StatusType(), $status);
            $request = $this->getRequest();
            $form->handleRequest($request);

            // 3) Traiter le formulaire
            if ($authenticatedUser && $form->isValid()) {
                $em->persist($status);
                $em->flush();
                $this->redirect($this->generateUrl(
                    'tech_corp_front_user_timeline', array(
                    'userId' => $authenticatedUser->getId()
                ))
                );
            }
            $statuses = $em->getRepository('TechCorpFrontBundle:Status')->findAll();
            
            return $this->render('TechCorpFrontBundle:Timeline:friends_timeline.html.twig',
            array(
                'user' => $authenticatedUser,
                'statuses' => $statuses,
                'form' => $form->createView(),
            ));
        }
}