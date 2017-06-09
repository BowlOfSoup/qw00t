<?php

namespace Security\Service;

use Security\Encoder\PasswordEncoder;
use Security\FormType\UserFormType;
use Security\Repository\UserRepository;

class UserService
{
    /** @var \Security\Repository\UserRepository */
    private $userRepository;

    /** @var \Security\Encoder\PasswordEncoder */
    private $passwordEncoder;

    /**
     * @param \Security\Repository\UserRepository $userRepository
     * @param \Security\Encoder\PasswordEncoder $passwordEncoder
     */
    public function __construct(
        UserRepository $userRepository,
        PasswordEncoder $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
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
        $this->passwordEncoder->validatePassword($data[UserFormType::PROPERTY_PASSWORD]);

        $data[UserFormType::PROPERTY_PASSWORD] =
            $this->passwordEncoder->encodePassword($data[UserFormType::PROPERTY_PASSWORD]);

//        return $this->userRepository->insert($data);
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function update(array $data)
    {
        return $this->userRepository->update($data, $data['id']);
    }
}
