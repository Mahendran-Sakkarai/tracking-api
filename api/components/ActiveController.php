<?php
/**
 * Parents controller for all ones
 *
 * @author Ihor Karas <ihor@karas.in.ua>
 * Date: 03.04.15
 * Time: 00:29
 */

namespace api\components;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ActiveController extends \yii\rest\ActiveController
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'authenticator' => [
				'class' => CompositeAuth::className(),
				'authMethods' => [
					HttpBasicAuth::className(),
					HttpBearerAuth::className(),
					QueryParamAuth::className(),
				],
			],
			'contentNegotiator' => [
				'class' => \yii\filters\ContentNegotiator::className(),
				'only' => ['index', 'view'],
				'formatParam' => "json",
				'formats' => Response::$formats,
			],
		]);
	}
}