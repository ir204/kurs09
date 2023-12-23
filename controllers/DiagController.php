<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii;
use yii\web\Response;
use app\models\Child;
use app\models\Nurse;
use app\models\Diag;
use app\models\Anam;

class DiagController extends ActiveController
{
public $modelClass = 'app\models\Diag';

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
  $diag = new Diag();
  $diag->diag = $request->post('diag');
  $diag->date_diag = date("Y-m-d H:i:s");
  $diag->recommends = $request->post('recommends');
  if ($request->post('anamn_id') != null) {
    $diag->anamn_id = $request->post('anamn_id');
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
  $diag->anamn_id = Anam::FindOne(
  ['nurse_id' => $anam->nurse_id] and 
  ['child_id' => $anam->child_id] and
  ['height' => $anam->height] and 
  ['weight' => $anam->weight] and
  ['sympthoms' => $anam->sympthoms] and 
  ['date_anamn' => $anam->date_anamn] and
  ['dop_info' => $anam->dop_info])->id_anamn;
  }
  $diag->save();
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
  $diag_name = $request->get('diag_name');
  $diag = Diag::findAll(['diag' => $diag_name]);
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=200;
  for ($counter = 0; $counter < count($diag); $counter++) {
  $anam = Anam::findOne(['id_anamn' => $diag[$counter]->anamn_id]);
  $response->data = [ 
  'data' => [
  'id_diag' => $diag[$counter]->id_diag, 
  'child_id' => $anam->child_id
 ] 
  ];
  }
  return $response;
  }
}

protected function findUserByToken($token)
{
  return Nurse::findOne(['token' => $token]);
}

}
