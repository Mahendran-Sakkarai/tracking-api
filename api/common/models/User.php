<?php
/**
 * Created by PhpStorm.
 * User: mahendran
 * Date: 5/3/16
 * Time: 4:17 PM
 */

namespace api\common\models;

use Yii;
use yii\web\HttpException;

class User extends \common\models\User
{
    public static function findByAccessToken($token)
    {
        if (empty($token))
            throw new HttpException(403, "Forbidden", 0);

        $user = User::find()->where(['access_token'=>$token])->one();
        
        if (empty($user))
            throw new HttpException(404, "Invalid User!!", 0);

        return $user;
    }
}