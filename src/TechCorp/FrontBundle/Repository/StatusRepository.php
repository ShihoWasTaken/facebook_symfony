<?php

namespace TechCorp\FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StatusRepository extends EntityRepository {


public function findAll()
{
    return $this->findBy(array(), array('createdAt' => 'DESC'));
}

public function getStatusesAndUsers ($deleted) {
return $this->_em->createQuery("
select s, u
from TechCorpFrontBundle:Status s
join s.user u
WHERE s.deleted = :deleted
ORDER BY
s.createdAt DESC,
s.id DESC
")
->setParameter('deleted', $deleted)
;
}

public function getUserTimeline ($user) {
return $this->_em->createQuery('
SELECT s, c, u
FROM TechCorpFrontBundle:Status s
LEFT JOIN s.comments c
LEFT JOIN c.user u
WHERE
s.user = :user
AND s.deleted = false
ORDER BY
s.createdAt DESC
')
->setParameter('user', $user);
;
}

public function getFriendsTimeline ($user) {
return $this->_em->createQuery('
SELECT s, c, u
FROM TechCorpFrontBundle:Status s
LEFT JOIN s.comments c
LEFT JOIN c.user u
WHERE s.user in (
SELECT friends FROM
TechCorpFrontBundle:User uf
JOIN uf.friends friends
WHERE uf = :user
)
ORDER BY
s.createdAt DESC
')
->setParameter('user', $user);
;
}
}
