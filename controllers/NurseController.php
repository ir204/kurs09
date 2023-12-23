<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii;
use yii\web\Response;
use app\models\Nurse;

class NurseController extends ActiveController
{
public $modelClass = 'app\models\Nurse';


public function actionAuth() {
$nurse = new Nurse();
$nurse->load(Yii::$app->request->post(), '');
$token = $nurse->auth();
if ($token !== null) {
  $response = $this->response;
  $response->setStatusCode(200);
  $response->data = ['data' => ['token' => $token]];
  return $response;
}
else {
$response = $this->response;
  $response->setStatusCode(404);
  $response->data = ['error'=> ['code'=> 403, 
    'message'=>'Неправильный логин или пароль']];
  return $response;
}
}

public function actionEdit() {
$request = Yii::$app->request;  
  $nurse_token = $this->findUserByToken(str_replace('Bearer ', '', $request->headers->get('Authorization')));
  if ($nurse_token == null) {
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=403;
    $response->data=['error'=>['code'=> 403, 
    'message'=>'Ошибка доступа']];
  }
  else {
  $id_nurse = Nurse::findOne(['id_nurse' => $request->post('id_nurse')]);
  $nurse->login = $request->post('login');
  $nurse->fio = $request->post('fio');
  $nurse->post = $request->post('post');
  $nurse->passport = $request->post('passport');
  $nurse->phone = $request->post('phone');
  $nurse->update();
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=204;
  $response->data = [ 
  'data' => 'null' 
  ]; 
  return $response;
}
}

public function actionDel() {
$request = Yii::$app->request; 
  $nurse_token = $this->findUserByToken(str_replace('Bearer ', '', $request->headers->get('Authorization')));
  if ($nurse_token == null) {
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=403;
    $response->data=['error'=>['code'=> 403, 
    'message'=>'Ошибка доступа']];
  }
  else { 
  $nurse = Nurse::findOne(
  ['id_nurse' => $request->post('id_nurse')])->delete();
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=204;
  $response->data = [ 
  'data' => 'null' 
  ]; 
  return $response;
}
}

public function actionCreate() {
$request = Yii::$app->request; 
  $nurse_token = $this->findUserByToken(str_replace('Bearer ', '', $request->headers->get('Authorization')));
  if ($nurse_token == null) {
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=403;
    $response->data=['error'=>['code'=> 403, 
    'message'=>'Ошибка доступа']];
  }
  else { 
  $nurse = new Nurse();
  $nurse->login = $request->post('login');
  $password = $request->post('password');
  $nurse->password = Yii::$app->getSecurity()->generatePasswordHash($password);
  $nurse->fio = $request->post('fio');
  $nurse->post = $request->post('post');
  $nurse->passport = $request->post('passport');
  $nurse->phone = $request->post('phone');
  $nurse->save();
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=204;
  $response->data = [ 
  'data' => 'null' 
  ]; 
  return $response;
}
}

protected function generateToken(){
  return Yii::$app->security->generateRandomString();
}
protected function findUserByToken($token)
{
  return Nurse::findOne(['token' => $token]);
}

}
