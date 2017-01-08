<?php
/**
 * Created by PhpStorm.
 * User: mahendran
 * Date: 14/3/16
 * Time: 7:13 PM
 */

namespace api\modules\v1\controllers;

use api\common\models\User;
use common\models\Helpers;
use frontend\models\PasswordResetRequestForm;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

class LoginController extends Controller
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $modelClass = 'common\models\LoginForm';

    public function actionIndex(){
        /* @var $model \common\models\LoginForm */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(empty($model->username) && empty($model->password)) {
            throw new ServerErrorHttpException('Fields are missing!');
        }

        if($model->loginByApi()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);

            echo Json::encode(User::find()->where(["id"=>$model->getUserId()])->one());
        } else {
            throw new HttpException(401, "You are requesting with a invalid credentials", 1);
        }
    }

    public function actionRegister(){
        $scenario = Model::SCENARIO_DEFAULT;
        $viewAction = 'view';
        $modelClass = 'api\common\models\User';

        /* @var $model \api\common\models\User */
        $model = new $modelClass([
            'scenario' => $scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(empty($model->username) && empty($model->password)) {
            throw new ServerErrorHttpException('Fields are missing!');
        }
        $users = $model->findByUsername($model->username);
        foreach($users as $user) {
            if (!empty($user && Yii::$app->authManager->getAssignment($model->role, $user->id))) {
                throw new ServerErrorHttpException('Already registered user.');
            }
        }
        $model->from = "api";
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

    public function actionForgotPassword(){
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                echo json_encode(["status" => 201, "message" => "Email sent to your mail id."]);
                return;
            } else {
                throw new HttpException(500, "Unable to send mail to your email address!", 1);
            }
        }

        throw new ServerErrorHttpException(json_encode($model->getErrors()));
    }
}