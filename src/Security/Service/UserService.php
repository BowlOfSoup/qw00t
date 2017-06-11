<?php

namespace Security\Service;

use Generic\Service\MetaService;
use Security\Encoder\PasswordEncoder;
use Security\FormType\UserFormType;
use Security\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UserService
{
    /** @var \Security\Repository\UserRepository */
    private $userRepository;

    /** @var \Security\Encoder\PasswordEncoder */
    private $passwordEncoder;

    /** @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage */
    private $tokenStorage;

    /** @var string */
    private $messageUserOrEmailAlreadyInUse;

    /**
     * @param \Security\Repository\UserRepository $userRepository
     * @param \Security\Encoder\PasswordEncoder $passwordEncoder
     * @param string $messageUserOrEmailAlreadyInUse
     */
    public function __construct(
        UserRepository $userRepository,
        PasswordEncoder $passwordEncoder,
        TokenStorage $tokenStorage,
        $messageUserOrEmailAlreadyInUse
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenStorage = $tokenStorage;
        $this->messageUserOrEmailAlreadyInUse = $messageUserOrEmailAlreadyInUse;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @return array|null
     */
    public function getAuthenticatedUser()
    {
        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            return null;
        }

        return $this->userRepository->findByUsername($token->getUser()->getUsername());
    }

    /**
     * @param array $data
     *
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return int
     */
    public function insert(array $data)
    {
        $this->validateUserName($data[UserFormType::PROPERTY_USERNAME]);
        $this->validateEmail($data[UserFormType::PROPERTY_EMAIL]);

        $this->passwordEncoder->validatePassword($data[UserFormType::PROPERTY_PASSWORD]);

        $data[UserFormType::PROPERTY_PASSWORD] =
            $this->passwordEncoder->encodePassword($data[UserFormType::PROPERTY_PASSWORD]);

        if (MetaService::hasMessageOfType(MetaService::TYPE_ERROR)) {
            return 0;
        }

        return $this->userRepository->insert($data);
    }

    /**
     * @param array $data
     * @param array $existingUser
     *
     * @return int
     */
    public function update(array $data, array $existingUser)
    {
        if (empty($data[UserFormType::PROPERTY_PASSWORD])) {
            unset($data[UserFormType::PROPERTY_PASSWORD]);
        } else {
            $this->passwordEncoder->validatePassword($data[UserFormType::PROPERTY_PASSWORD]);

            $data[UserFormType::PROPERTY_PASSWORD] =
                $this->passwordEncoder->encodePassword($data[UserFormType::PROPERTY_PASSWORD]);
        }

        if ($existingUser[UserFormType::PROPERTY_USERNAME] !== $data[UserFormType::PROPERTY_USERNAME]) {
            $this->validateUserName($data[UserFormType::PROPERTY_USERNAME]);
        }
        if ($existingUser[UserFormType::PROPERTY_EMAIL] !== $data[UserFormType::PROPERTY_EMAIL]) {
            $this->validateEmail($data[UserFormType::PROPERTY_EMAIL]);
        }

        if (MetaService::hasMessageOfType(MetaService::TYPE_ERROR)) {
            return 0;
        }

        return $this->userRepository->update($data, $existingUser['id']);
    }

    /**
     * @param string $userName
     */
    private function validateUserName($userName)
    {
        $existingUser = $this->userRepository->findByUsername($userName);
        if (!empty($existingUser)) {
            MetaService::addMessage(sprintf($this->messageUserOrEmailAlreadyInUse, $userName));
        }
    }

    /**
     * @param string $email
     */
    private function validateEmail($email)
    {
        $existingUser = $this->userRepository->findByEmail($email);
        if (!empty($existingUser)) {
            MetaService::addMessage(sprintf($this->messageUserOrEmailAlreadyInUse, $email));
        }
    }
}
