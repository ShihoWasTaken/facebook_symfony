<?php

namespace TechCorp\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TechCorp\FrontBundle\Entity\Comment;

class CommentController extends Controller
{
    public function addCommentAction($statusId)
    {
        $em = $this->getDoctrine()->getManager();

        $request = Request::createFromGlobals();
        $text = $request->request->get('commentText', 'default value if bar does not exist');

        $authenticatedUser = $this->get('security.context')->getToken()->getUser();

        $status = $em->getRepository('TechCorpFrontBundle:status')->findOneById($statusId);
        $friend =  $status->getUser();
        $friendId = $friend->getId();

        $comment = new Comment();
        $comment->setContent($text);
        $comment->setStatus($status);
        $comment->setUser($authenticatedUser);
        $em->persist($comment);
        $em->flush();

        return $this->forward('TechCorpFrontBundle:Timeline:userTimeline', array('userId'=> $friendId));
    }
}