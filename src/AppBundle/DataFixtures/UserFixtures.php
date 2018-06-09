<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends FixtureHelper
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        parent::__construct();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadAdmin($manager);
    }

    private function loadAdmin(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('admin@test.fr')
            ->setPlainPassword('admin');
        $password = $this->encoder
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password)
            ->eraseCredentials();

        $this->setReference('user-admin', $user);
        $manager->persist($user);
        $manager->flush();
    }
}
