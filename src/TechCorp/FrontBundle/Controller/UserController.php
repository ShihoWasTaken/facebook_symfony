<?php

namespace TechCorp\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use TechCorp\FrontBundle\Services\FriendService;
class UserController
{
    private $securityContext;
    private $friendService;
    public function __construct (
        SecurityContextInterface $securityContext,
FriendService $friendService) {
$this->securityContext = $securityContext;
$this->friendService = $friendService;
}
public function addFriendAction($friendId){
    $authenticatedUser = $this->securityContext->getToken()->getUser();
    $response = new Response("OK");
    if (!$authenticatedUser) {
        $response = new Response("Authentification nécessaire", 401);
    }
    else {
        if (!$this->friendService->addFriend($authenticatedUser, $friendId)) {
$response = new Response("Utilisateur inexistant", 400);
}
    }
    return $response;
}
public function removeFriendAction($friendId){
    $authenticatedUser = $this->securityContext->getToken()->getUser();
    $response = new Response("OK");
    if (!$authenticatedUser) {
        $response = new Response("Authentification nécessaire", 401);
    }
    else {
        if (!$this->friendService->removeFriend($authenticatedUser,
            $friendId)) {
$response = new Response("Utilisateur inexistant", 400);
}
    }
    return $response;
}
}