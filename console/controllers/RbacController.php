<?php
/**
 * Created by PhpStorm.
 * User: mahendran
 * Date: 9/3/16
 * Time: 4:32 PM
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
    }
}