<?php
namespace TechCorp\FrontBundle\Services;
use Doctrine\ORM\EntityManager;
class FriendService {
private $entityManager;
public function __construct(EntityManager $manager){
$this->entityManager = $manager;
}
public function addFriend($authenticatedUser, $friendId){
$userRepository = $this->entityManager
->getRepository('TechCorpFrontBundle:user');
$friend = $userRepository->findOneById($friendId);
$result = false;
if ($friend && !$authenticatedUser->hasFriend($friend)){
$authenticatedUser->addFriend($friend);
$this->entityManager->persist($authenticatedUser);
$this->entityManager->flush();
$result = true;
}
return $result;
}
public function removeFriend($authenticatedUser, $friendId){
$userRepository = $this->entityManager
->getRepository('TechCorpFrontBundle:user');
$friend = $userRepository->findOneById($friendId);
$result = false;
if ($friend){
$authenticatedUser->removeFriend($friend);
$this->entityManager->persist($authenticatedUser);
$result = $this->entityManager->flush();
$this->entityManager->flush();
$result = true;
}
return $result;
}
}