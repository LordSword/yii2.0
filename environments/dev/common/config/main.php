<?php
// mysql mongodb redis 等配置
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=advanced',
            'username' => 'root',
            'password' => 'root',
            'tablePrefix' => 'ps_',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
            //'schemaCacheDuration' => 24*3600,
            //'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
