<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'name' => 'Eyee',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\common\controllers',
    'modules' => [
        /*'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'api\common\models\User',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ],*/
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'   // here is our v1 modules
        ]
    ],
    'components' => [
        'user' => [
            // 'identityClass' => 'api\common\models\User', // OAuth2 based credentials
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'response' => [
            'class' => 'api\components\Response'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                //'GET <module:\w+>/<controller:\w+>'=>'<module>/<controller>',
                // Api to generate or reset token using oauth2
                //'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                //'GET authorize' => 'site/authorize',
                'POST v1/register' => 'v1/login/register',
                'POST v1/login' => 'v1/login/index',
                'POST v1/get-access-token' => 'v1/login/get-access-token',
                'GET v1/default' => 'v1/default/index',
                'GET v1/users' => 'v1/tracker/users',
                'GET v1/tracker/<id>' => 'v1/tracker/get-tracker-by-user',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/tracker' => 'v1/tracker'
                    ],
                    'extraPatterns' => [
                        'GET search' => 'search'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
