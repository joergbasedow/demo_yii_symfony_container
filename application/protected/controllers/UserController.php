<?php

class UserController extends Controller
{
    public function actionView($id)
    {
        $user = Yii::app()->db->createCommand('SELECT * FROM tbl_user WHERE id = :id')->queryRow(true, ['id' => $id]);

        if (!$user) {
            throw new CHttpException(404, 'Not found');
        }

        $user['password'] = '******';

        $photoPath = Yii::app()->basePath.'/data/users'.$user['username'].'.jpg';

        $this->render('view', ['user' => $user, 'photoPath' => $photoPath]);
    }
}
