<?php

class UserController extends Controller
{
    public function actionView($id)
    {
        $user = $this->getUserRepository()->find($id);

        if (!$user) {
            throw new CHttpException(404, 'Not found');
        }

        $this->render('view', [
            'user' => $user,
            'photoPath' => $this->getUserService()->getPhotoForUser($user),
        ]);
    }

    /**
     * @return UserRepository
     */
    private function getUserRepository()
    {
        return $this->getContainer()->get('userRepository');
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->getContainer()->get('userService');
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface|IApplicationComponent
     */
    protected function getContainer()
    {
        return Yii::app()->getComponent('container');
    }
}
