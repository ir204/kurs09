<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii;
use yii\web\Response;
use app\models\Child;
use app\models\Par;
class ParController extends ActiveController
{
public $modelClass = 'app\models\Par';

public function actionTest() {
die('Привет');
}
}