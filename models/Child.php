<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "child".
 *
 * @property int $id_child
 * @property string $fio
 * @property string|null $photo
 * @property int|null $parent_id
 * @property string|null $diag_ids
 * @property string $birth_date
 * @property string|null $birth_passport
 * @property string|null $address
 * @property int|null $last_anamn
 *
 * @property Anam[] $anams
 * @property Parent $parent
 */
class Child extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'birth_date'], 'required'],
            [['photo', 'diag_ids', 'address'], 'string'],
            [['parent_id', 'last_anamn'], 'integer'],
            [['birth_date'], 'safe'],
            [['fio'], 'string', 'max' => 64],
            [['birth_passport'], 'string', 'max' => 16],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parent::class, 'targetAttribute' => ['parent_id' => 'id_parent']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_child' => 'Id Child',
            'fio' => 'Fio',
            'photo' => 'Photo',
            'parent_id' => 'Parent ID',
            'diag_ids' => 'Diag Ids',
            'birth_date' => 'Birth Date',
            'birth_passport' => 'Birth Passport',
            'address' => 'Address',
            'last_anamn' => 'Last Anamn',
        ];
    }
    public function gtr(){
    
    }
    /**
     * Gets query for [[Anams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnams()
    {
        return $this->hasMany(Anam::class, ['child_id' => 'id_child']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Parent::class, ['id_parent' => 'parent_id']);
    }
}
