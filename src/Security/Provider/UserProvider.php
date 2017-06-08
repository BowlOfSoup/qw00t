<?php

namespace Security\Provider;

use Security\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /** /** @var \Security\Repository\UserRepository */
    private $userRepository;

    /**
     * @param \Security\Repository\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Gets the user for the given username.
     *
     * @param string $userName
     *
     * @return \Symfony\Component\Security\Core\User\User
     */
    public function loadUserByUsername($userName)
    {
        $user = $this->userRepository->findByUsername(strtolower($userName));

        if (empty($user)) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $userName));
        }

        // explode(',', $user['roles'])
        return new User($user['username'], $user['password'], array(), true, true, true, true);
    }

    /**
     * Refreshes the user for the account interface.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @return \Symfony\Component\Security\Core\User\User|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * The user class this provider supports.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}
