<?php
/**
 * Created by PhpStorm.
 * User: Nandakumar
 * Date: 1/8/2017
 * Time: 3:41 AM
 */

namespace api\modules\v1\controllers;


use api\common\models\User;
use api\components\ActiveController;
use common\models\Tracker;
use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\rest\Action;
use yii\web\HttpException;

class TrackerController extends ActiveController
{
    public $modelClass = 'common\models\Tracker';

    public function actions()
    {
        $action = parent::actions();
        $action['create'] = [
            'class' => 'api\modules\v1\controllers\TrackerCreateAction',
            'modelClass' => $this->modelClass
        ];
        unset($action['index'], $action['view']);
        return $action;
    }

    public function actionUsers()
    {
        $accessToken = \Yii::$app->getRequest()->getQueryParam('access-token');

        if (empty($accessToken))
            throw new HttpException(403, "Forbidden", 0);

        $user = User::findByAccessToken($accessToken);

        if ($user->validateRole("admin")) {
            $users = User::find()->all();
            $usersToReport = [];
            foreach ($users as $user) {
                if ($user->validateRole("user")) {
                    $usersToReport[] = $user;
                }
            }

            echo Json::encode($usersToReport);
        } else {
            throw new HttpException(403, "Forbidden", 0);
        }
    }

    public function actionGetTrackerByUser($id) {
        $accessToken = \Yii::$app->getRequest()->getQueryParam('access-token');
        $start_time = \Yii::$app->getRequest()->getQueryParam('start');

        if (empty($accessToken))
            throw new HttpException(403, "Forbidden", 0);

        $user = User::findByAccessToken($accessToken);

        if ($user->validateRole("admin")) {
            $usersQuery = Tracker::find()->where(["user_id" => $id]);

            if(!empty($start_time))
                $usersQuery->andWhere("created_at >= $start_time");

            $tracks = $usersQuery->all();

            echo Json::encode($tracks);
        } else {
            throw new HttpException(403, "Forbidden", 0);
        }
    }
}

class TrackerCreateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;
    /**
     * @var string the name of the view action. This property is need to create the URL when the model is successfully created.
     */
    public $viewAction = 'view';


    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws HttpException
     * @throws ServerErrorHttpException if there is any error when creating the model
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $accessToken = \Yii::$app->getRequest()->getQueryParam('access-token');

        $user = User::findByAccessToken($accessToken);

        $tracking_details = json_decode(Yii::$app->getRequest()->getRawBody(), true);

        if ($user->validateRole("user")) {
            if(!empty($tracking_details)) {
                foreach ($tracking_details as $tracking_detail) {
                    $tracker = new Tracker();
                    $tracker->load($tracking_detail, '');
                    $validateAvailability = Tracker::find()->where(["client_id" => $tracker->client_id, "user_id" => $user->id])->one();
                    if (empty($validateAvailability)) {
                        $tracker->user_id = $user->id;
                        $tracker->save();
                    }
                }
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                echo Json::encode(["status" => "success", "message" => "Saved Successfully."]);
            }else{
                throw new HttpException(503, "Invalid Argument Posted.", 0);
            }
        } else {
            throw new HttpException(403, "Forbidden", 0);
        }
    }
}