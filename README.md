1. Clone this project inside a new folder using below command.
```
git clone https://github.com/Mahendran-Sakkarai/tracking-api.git .
```

2. Run the below command to initialize the default files.
```
php init
```

3. Run the below command to download the yii2 and dependency files.
```
composer update
```
Note: If you are getting bower-asset/jquery not found error run the below command and run the `composer update` command.
```
composer global require "fxp/composer-asset-plugin:^1.2.0"
```
For more details refer the official yii (documentation)[http://www.yiiframework.com/doc-2.0/guide-start-installation.html#installing-yii]

4. Create a database and update the created db credentials in the `common\config\main-local.php` file.

5. And also add the below credentials inside components to send mail using sendgrid in the `common\config\main-local.php` file.
```
<?php
return [
    'components' => [
        .
        .
        .
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // 'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'Host' => '---- host name ---',
                'Port' => 587,
                // 'SMTPAuth' => true,
                'Username' => '---- email id ----',
                'Password' => '---- password ----',
                'encryption' => 'tls',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ],
                ]
            ]
        ],
        .
        .
        .
    ],
];
```

6. Then run the below commands to create the tables from migration.
```
./yii migrate --migrationPath=@yii/rbac/migrations
./yii rbac/init
./yii migrate
```

7. Add the frontend, backend and api url to the file `common\config\params-local.php` like below.
```
    <?php
    return [
        "frontend_url" => "http://localhost/tracker/frontend/web/",
        "backend_url" => "http://localhost/tracker/backend/web/",
        "api_url" => "http://localhost/tracker/api/web/",
    ];
```
Note: Change the urls according to your setup. And `/` at the end of the url is compulsory.

8. Then in the index.php of `backend\web\` and `frontend\web\` add `require(__DIR__ . '/../../common/config/aliases.php');` next to `require(__DIR__ . '/../config/bootstrap.php');`.

Yii 2 Advanced Project Template
===============================

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
