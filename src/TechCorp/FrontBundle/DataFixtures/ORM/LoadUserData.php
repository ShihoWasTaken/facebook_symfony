<?php
namespace TechCorp\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TechCorp\FrontBundle\Entity\User;
use TechCorp\FrontBundle\Entity\Status;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
	const MAX_NB_USERS = 10;
        
        /**
        * @var ContainerInterface
        */
        private $container;
        /**
        * {@inheritDoc}
        */
        public function setContainer(ContainerInterface $container = null)
        {
        $this->container = $container;
        }
        
	public function load(ObjectManager $manager)
	{
		$faker = \Faker\Factory::create();
                $userManager = $this->container->get('fos_user.user_manager');
                
		for ($i=0; $i<self::MAX_NB_USERS; ++$i)
		{
			// On crée un nouvel utilisateur.
			$user = new User();
			$user->setUsername($faker->firstName . ' '.  $faker->lastName);
			$user->setEmail($faker->email);
			$user->setPlainPassword($faker->password);
			$user->setProfilepic($i . '.jpg');
			$user->setEnabled(true);
			$manager->persist($user);
			$this->addReference('user'.$i, $user);
		}
                
                $user = $userManager->createUser();
                $user->setUsername('user');
                $user->setEmail($faker->email);
                $user->setPlainPassword('password');
				$user->setProfilepic('11.jpg');
                $user->setEnabled(true);
                $manager->persist($user);
                
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 1;
	}
}