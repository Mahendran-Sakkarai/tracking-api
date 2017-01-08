<?php
/**
 * Created by PhpStorm.
 * User: mahendran
 * Date: 24/3/16
 * Time: 1:34 PM
 */

namespace api\components;


use Yii;
use yii\filters\ContentNegotiator;
use yii\web\UnsupportedMediaTypeHttpException;

/**
 * @property array formats
 * @property string formatParam
 */
class Response extends \yii\web\Response
{
    public static $formatParam = "_format";
    public static $formats = [
        'application/json' => \yii\web\Response::FORMAT_JSON,
        'application/xml' => \yii\web\Response::FORMAT_XML,
    ];

    public function init(){
        $request = Yii::$app->getRequest();
        $this->formatters = $this->defaultFormatters();
        if (!empty(self::$formatParam) && ($requestFormat = $request->get(self::$formatParam)) !== null) {
            if (in_array($requestFormat, self::$formats)) {
                $this->format = $requestFormat;
                return;
            } else {
                throw new UnsupportedMediaTypeHttpException('The requested response format is not supported: ' . $requestFormat);
            }
        }
    }
}