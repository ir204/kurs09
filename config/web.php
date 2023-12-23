<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$config = [
 'id' => 'basic',
 'name'=>'med',
 'language'=>'ru-RU',
 'basePath' => dirname(__DIR__),
 'bootstrap' => ['log'],
 'aliases' => [
 '@bower' => '@vendor/bower-asset',
 '@npm' => '@vendor/npm-asset',
 ],
 'components' => [
 'request' => [
 // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
 'cookieValidationKey' => 'pankrushin',
 'parsers' => [
 'application/json' => 'yii\web\JsonParser',
 ]
 ],
 'cache' => [
 'class' => 'yii\caching\FileCache',
 ],
 'user' => [
 'identityClass' => 'app\models\User',
 'enableAutoLogin' => true,
 ],
 'errorHandler' => [
 'errorAction' => 'site/error',
 ],
 'mailer' => [
 'class' => 'yii\swiftmailer\Mailer',
 // send all mails to a file by default. You have to set
 // 'useFileTransport' to false and configure transport
 // for the mailer to send real emails.
 'useFileTransport' => true,
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
 'db' => $db,
 'urlManager' => [
'enablePrettyUrl' => true,
'enableStrictParsing' => true,
'showScriptName' => false,
'rules' => [
['class' => 'yii\rest\UrlRule', 'controller' => 'Nurse'],
['class' => 'yii\rest\UrlRule', 'controller' => 'Child'],
['class' => 'yii\rest\UrlRule', 'controller' => 'Par'],
['class' => 'yii\rest\UrlRule', 'controller' => 'Anam'],
['class' => 'yii\rest\UrlRule', 'controller' => 'Diag'], // и так далее все табл.
'GET child/test' => 'child/test',
'GET par/test' => 'par/test',
'GET anam/test' => 'anam/test',
'GET diag/test' => 'diag/test', // test

'GET child/get' => 'child/get', // ++
'POST child/add' => 'child/create', // ++
'POST child/edit' => 'child/edit', // ++
'POST child/del' => 'child/del', // ++
'POST anam/add' => 'anam/create', // ++
'GET anam/get' => 'anam/get', // ++
'POST diag/add' => 'diag/create', // ++
'GET diag/get' => 'diag/get', // ++
'POST nurse/auth' => 'nurse/auth', // ++
'POST nurse/del' => 'nurse/del', // ++
'POST nurse/add' => 'nurse/create', // ++
'POST nurse/edit' => 'nurse/edit' // ++
],
]
 ],
 'params' => $params,
];
if (YII_ENV_DEV) {
 // configuration adjustments for 'dev' environment
 $config['bootstrap'][] = 'debug';
 $config['modules']['debug'] = [
 'class' => 'yii\debug\Module',
 // uncomment the following to add your IP if you are not connecting from localhost.
 'allowedIPs' => ['127.0.0.1', '::1', '*'],
 ];
 $config['bootstrap'][] = 'gii';
 $config['modules']['gii'] = [
 'class' => 'yii\gii\Module',
 // uncomment the following to add your IP if you are not connecting from localhost.
 'allowedIPs' => ['127.0.0.1', '::1','*' ],
 ];
}
return $config;
