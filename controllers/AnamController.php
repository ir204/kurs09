<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii;
use yii\web\Response;
use app\models\Child;
use app\models\Nurse;
use app\models\Diag;
use app\models\Anam;

class AnamController extends ActiveController
{
public $modelClass = 'app\models\Anam';

public function actionTest() {
die('Привет');
}

public function actionCreate() {
  $request = Yii::$app->request;
  $nurse = $this->findUserByToken(str_replace('Bearer ', '', $request->headers->get('Authorization')));
  if ($nurse == null) {
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=403;
    $response->data=['error'=>['code'=> 403, 
    'message'=>'Ошибка доступа']];
  }
  else {  
  $anam = new Anam();
  $anam->nurse_id = $request->post('nurse_id');
  $anam->child_id = $request->post('child_id');
  $anam->height = $request->post('height');
  $anam->weight = $request->post('weight');
  $anam->sympthoms = $request->post('sympthoms');
  $anam->date_anamn = date("Y-m-d H:i:s");
  $anam->dop_info = $request->post('dop_info'); 
  $anam->save();
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=204;
  $response->data = [ 
  'data' => 'null' 
  ]; 
  return $response;
  }
}

public function actionGet() {
$request = Yii::$app->request;
  $nurse = $this->findUserByToken(str_replace('Bearer ', '', $request->headers->get('Authorization')));
  if ($nurse == null) {
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=403;
    $response->data=['error'=>['code'=> 403, 
    'message'=>'Ошибка доступа']];
  }
  else {
  $id_anam = $request->get('id_anam');
  $anam = Anam::findOne(['id_anamn' => $id_anam]);
  $anam->load($anam,'');
  $nurse = Nurse::findOne(['id_nurse' => $anam->nurse_id]);
  $nurse->load($nurse,'');
  $child = Child::findOne(['id_child' => $anam->child_id]);
  $child->load($child,'');
  $diag = Diag::findOne(['anamn_id'=>$anam->id_anamn]);
  //$diag->load($diag,'');
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=200;
  $response->data = [ 
  'data' => [
  'fio' => $child->fio, 
  'nurse_fio' => $nurse->fio,
  'height' => $anam->height,
  'weight' => $anam->weight,
  'sympthoms' => $anam->sympthoms, 
  'date_anamn' => $anam->date_anamn, 
  'dop_info' => $anam->dop_info, 
  'diag' => $diag->diag, 
  'recommends' => $diag->recommends,
 ] 
  ];
  return $response;
  }
}
protected function findUserByToken($token)
{
  return Nurse::findOne(['token' => $token]);
}

}