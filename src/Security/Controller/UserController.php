<?php

namespace Security\Controller;

use Generic\Controller\AbstractController;
use Generic\FormType\FormTypeInterface;
use Security\Service\UserService;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /** @var \Security\Service\UserService */
    private $userService;

    /** @var \Generic\FormType\FormTypeInterface */
    private $userFormType;

    /**
     * @param \Security\Service\UserService $userService
     * @param \Generic\FormType\FormTypeInterface $userFormType
     */
    public function __construct(
        UserService $userService,
        FormTypeInterface $userFormType
    ) {
        $this->userService = $userService;
        $this->userFormType = $userFormType;
    }

    /**
     * Create a user.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $userForm = $this->userFormType->buildForm();
        $userForm->handleRequest($request);

        if ($this->isFormValid($userForm)) {
            $result = $this->userService->insert($userForm->getData());
            if (0 === $result) {
                return $this->response();
            }

            return $this->response($userForm->getData());
        }

        return $this->response();
    }

    /**
     * {@inheritdoc}
     */
    protected function response(array $controllerResult = array())
    {
        $this->responseMapping = array(
            'username' => 'userName',
            'password' => null,
        );

        return parent::response($controllerResult);
    }
}
