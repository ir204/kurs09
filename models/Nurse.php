<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nurse".
 *
 * @property int $id_nurse
 * @property string $login
 * @property string $password
 * @property string $fio
 * @property string $post
 * @property string|null $passport
 * @property string|null $phone
 * @property string|null $token
 *
 * @property Anam[] $anams
 */
class Nurse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nurse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'fio', 'post'], 'required'],
            [['password'], 'string'],
            [['login'], 'string', 'max' => 32],
            [['fio', 'post'], 'string', 'max' => 64],
            [['passport'], 'string', 'max' => 16],
            [['phone'], 'string', 'max' => 10],
            [['token'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_nurse' => 'Id Nurse',
            'login' => 'Login',
            'password' => 'Password',
            'fio' => 'Fio',
            'post' => 'Post',
            'passport' => 'Passport',
            'phone' => 'Phone',
            'token' => 'Token',
        ];
    }

    /**
     * Gets query for [[Anams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnams()
    {
        return $this->hasMany(Anam::class, ['nurse_id' => 'id_nurse']);
    }

    public function auth()
    {
        
            $nurse = Nurse::findOne(['login' => $this->login]);

            if ($nurse && Yii::$app->getSecurity()->validatePassword($this->password, $nurse->password)) {
                $token = $this->generateToken();
                $nurse->token = $token;
                $nurse->save(false);
                return $token;
            }
        

        return null;
    }
    
    protected function generateToken()
    {
        return Yii::$app->Security->generateRandomString();
    }
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
