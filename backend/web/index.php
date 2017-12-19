<?php
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/common/config/main.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../../environments/' . YII_ENV . '/backend/config/main.php')
);

(new yii\web\Application($config))->run();
/*
 * $config =
 * Array
(
    [aliases] => Array
        (
            [@bower] => @vendor/bower-asset
            [@npm] => @vendor/npm-asset
        )

    [vendorPath] => /Library/WebServer/Documents/yii2.0-composer/vendor
    [language] => zh-CN
    [timeZone] => Asia/Shanghai
    [components] => Array
        (
            [db] => Array
                (
                    [class] => yii\db\Connection
                    [dsn] => mysql:host=127.0.0.1;dbname=advanced
                    [username] => root
                    [password] => root
                    [tablePrefix] => ps_
                    [charset] => utf8
                    [enableSchemaCache] =>
                )

            [mailer] => Array
                (
                    [class] => yii\swiftmailer\Mailer
                    [viewPath] => @common/mail
                    [useFileTransport] => 1
                )

            [view] => Array
                (
                    [class] => backend\components\View
                )

            [user] => Array
                (
                    [identityClass] => backend\models\UserBackend
                    [enableAutoLogin] => 1
                )

            [session] => Array
                (
                    [name] => advanced-backend
                )

            [log] => Array
                (
                    [traceLevel] => 3
                    [targets] => Array
                        (
                            [0] => Array
                                (
                                    [class] => yii\log\FileTarget
                                    [levels] => Array
                                        (
                                            [0] => error
                                            [1] => warning
                                        )

                                )

                        )

                )

            [errorHandler] => Array
                (
                    [errorAction] => site/error
                )

            [request] => Array
                (
                    [class] => backend\components\Request
                    [cookieValidationKey] => umzSrJyw4igf7IjPeQukzEHEQWkZPkoe
                )

        )

    [id] => app-backend
    [basePath] => /Library/WebServer/Documents/yii2.0-composer/backend
    [controllerNamespace] => backend\controllers
    [defaultRoute] => site/index
    [bootstrap] => Array
        (
            [0] => log
            [1] => debug
            [2] => gii
        )

    [modules] => Array
        (
            [debug] => Array
                (
                    [class] => yii\debug\Module
                )

            [gii] => Array
                (
                    [class] => yii\gii\Module
                    [allowedIPs] => Array
                        (
                            [0] => 127.0.0.1
                            [1] => ::1
                        )

                )

        )

    [params] => Array
        (
            [adminEmail] => admin@example.com
            [supportEmail] => support@example.com
            [user.passwordResetTokenExpire] => 3600
            [smsService_1] => apikey:0da4c0d9b661128b12595a4aaa5290ea
        )

)
 */

/**
 * Array
(
    [HTTP_HOST] => localhost
    [HTTP_CONNECTION] => keep-alive
    [HTTP_CACHE_CONTROL] => max-age=0
    [HTTP_USER_AGENT] => Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36
    [HTTP_UPGRADE_INSECURE_REQUESTS] => 1
    [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,;q=0.8
    [HTTP_ACCEPT_ENCODING] => gzip, deflate, br
    [HTTP_ACCEPT_LANGUAGE] => zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4
    [HTTP_COOKIE] => _csrf=c2316686ae3fccc74384f4fb705178077c11029e0138ba337e3ed3d3b97cdd15a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22%84%83%E1%03_I%BE%5E%1B%86%F7%5CLB%A8U%BA%B2%7F2E%E8%15%01%92R%F7%0A%DAj%EC%15%22%3B%7D; advanced-backend=363811d8447cf576b3eafb1c9a7728c6
    [PATH] => /usr/bin:/bin:/usr/sbin:/sbin
    [SERVER_SIGNATURE] =>
    [SERVER_SOFTWARE] => Apache/2.4.25 (Unix) PHP/5.6.30
    [SERVER_NAME] => localhost
    [SERVER_ADDR] => ::1
    [SERVER_PORT] => 80
    [REMOTE_ADDR] => ::1
    [DOCUMENT_ROOT] => /Library/WebServer/Documents
    [REQUEST_SCHEME] => http
    [CONTEXT_PREFIX] =>
    [CONTEXT_DOCUMENT_ROOT] => /Library/WebServer/Documents
    [SERVER_ADMIN] => you@example.com
    [SCRIPT_FILENAME] => /Library/WebServer/Documents/yii2.0-composer/backend/web/index.php
    [REMOTE_PORT] => 53982
    [GATEWAY_INTERFACE] => CGI/1.1
    [SERVER_PROTOCOL] => HTTP/1.1
    [REQUEST_METHOD] => GET
    [QUERY_STRING] =>
    [REQUEST_URI] => /yii2.0-composer/backend/web/index.php
    [SCRIPT_NAME] => /yii2.0-composer/backend/web/index.php
    [PHP_SELF] => /yii2.0-composer/backend/web/index.php
    [REQUEST_TIME_FLOAT] => 1508341001.686
    [REQUEST_TIME] => 1508341001
    [argv] => Array
        (
        )

    [argc] => 0
)
 */