<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii;
use yii\web\Response;
use app\models\Child;
use app\models\Par;
use app\models\Nurse;
class ChildController extends ActiveController
{
public $modelClass = 'app\models\Child';


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
    $id_child = $request->get('id_child');
    if ($id_child != null) {
      $child = Child::findOne(['id_child' => $id_child]);
      $child->load($child,'');
      $par = Par::findOne(['id_parent' => $child->parent_id]);
      $par->load($par,'');
      $response = $this->response;
      $response->format = yii\web\Response::FORMAT_JSON;
      $response->statusCode=200;
      $response->data = [ 
      'data' => [
      'fio' => $child->fio, 
      'photo' => $child->photo,
      'parent_id' => $child->parent_id,
      'diag_ids' => $child->diag_ids,
      'birth_date' => $child->birth_date, 
      'birth_passport' => $child->birth_passport, 
      'address' => $child->address, 
      'last_anamn' => $child->last_anamn, 
      'fio_par' => $par->fio,
      'passport' => $par->passport,
      'phone' => $par->phone] 
      ];
      return $response;
    }
    else {
      $fio = $request->get('fio');
      $par_id = $request->get('par_id');
      //$diags_id = $request->get('diags_id');
      $birth_date = $request->get('birth_date');
      $b_passport = $request->get('b_passport');
      $address = $request->get('address');
      $last_anamn = $request->get('last_anamn');
      $par_fio = $request->get('par_fio');
      $par_pass = $request->get('par_pass');
      $par_phone = $request->get('par_phone');
      if ($par_fio != null or $par_pass != null or $par_phone != null) {
        $par = Par::findOne(['fio' => $par_fio] or ['passport' => $par_pass] or
        ['phone' => $par_phone]);
      }
      $child = Child::find()->where(['fio'=>$fio] or ['parent_id'=>$par->id_parent] or 
      ['parent_id' => 'par_id'] or ['birth_date'=>$birth_date] or ['b_passport'=>$b_passport] or
      ['address'=>$address] or ['last_anamn'=>$last_anamn])->all();
      //$child->load($child,'');
      $response = $this->response;
      $response->format = yii\web\Response::FORMAT_JSON;
      $response->statusCode=200;
      for ($counter = 0; $counter < count($child); $counter++) {
        $response->data = ['id_child'=>$child[$counter]->id_child];  
      }
    }
    return $response;
  }
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
    $child = new Child();
    $child->fio = $request->post('fio');
    $child->photo = $request->post('photo');
    $child->birth_date = $request->post('birth_date');
    $child->birth_passport = $request->post('birth_passport');
    $child->address = $request->post('address');
    /*if ($request->post('parent_id') !== null) { 
      $child->parent_id = $request->post('parent_id');
    } 
    else { 
      $par = new Par();
      $par->fio = $request->post('parfio');
      $par->passport = $request->post('passport');
      $par->phone = $request->post('phone');
      $par->save();
      $child->parent_id = Par::findOne(
      ['fio' => $par->fio] and ['passport' => $par->passport] and
      ['phone' => $par->phone])->id_parent;
    }*/
    $child->save();
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=204;
    $response->data = [ 
    'data' => 'null' 
    ]; 
    return $response;
    }
}



public function actionEdit() {
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
  $id_child = $request->post('id_child');
  $child = Child::findOne(['id_child' => $id_child]);
  $child->fio = $request->post('fio');
  $child->photo = $request->post('photo');
  $child->birth_date = $request->post('birth_date');
  $child->birth_passport = $request->post('birth_passport');
  $child->address = $request->post('address');
  /*if ($request->post('parent_id') !== null) { 
    $child->parent_id = $request->post('parent_id');
  } 
  else { 
    $par = Par::findOne(['id_parent' => $request->post('parent_id')]);
    $par->fio = $request->post('parfio');
    $par->passport = $request->post('passport');
    $par->phone = $request->post('phone');
    $par->update();
  }*/
  $child->update();
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
  $nurse = $this->findUserByToken(str_replace('Bearer ', '', $request->headers->get('Authorization')));
  if ($nurse == null) { 
    $response = $this->response;
    $response->format = yii\web\Response::FORMAT_JSON;
    $response->statusCode=403;
    $response->data=['error'=>['code'=> 403, 
    'message'=>'Ошибка доступа']];
  }  
  else {
  $child = Child::findOne(
  ['id_child' => $request->post('id_child')])->delete();
  $response = $this->response;
  $response->format = yii\web\Response::FORMAT_JSON;
  $response->statusCode=204;
  $response->data = [ 
  'data' => 'null' 
  ]; 
  return $response;
  }
}

protected function findUserByToken($token)
{
  return Nurse::findOne(['token' => $token]);
}

}
