<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anam".
 *
 * @property int $id_anamn
 * @property int $nurse_id
 * @property int $child_id
 * @property int|null $height
 * @property int|null $weight
 * @property string|null $sympthoms
 * @property string|null $date_anamn
 * @property string|null $dop_info
 *
 * @property Child $child
 * @property Diag[] $diags
 * @property Nurse $nurse
 */
class Anam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nurse_id', 'child_id'], 'required'],
            [['nurse_id', 'child_id', 'height', 'weight'], 'integer'],
            [['sympthoms', 'dop_info'], 'string'],
            [['date_anamn'], 'safe'],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => Child::class, 'targetAttribute' => ['child_id' => 'id_child']],
            [['nurse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nurse::class, 'targetAttribute' => ['nurse_id' => 'id_nurse']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_anamn' => 'Id Anamn',
            'nurse_id' => 'Nurse ID',
            'child_id' => 'Child ID',
            'height' => 'Height',
            'weight' => 'Weight',
            'sympthoms' => 'Sympthoms',
            'date_anamn' => 'Date Anamn',
            'dop_info' => 'Dop Info',
        ];
    }

    /**
     * Gets query for [[Child]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(Child::class, ['id_child' => 'child_id']);
    }

    /**
     * Gets query for [[Diags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiags()
    {
        return $this->hasMany(Diag::class, ['anamn_id' => 'id_anamn']);
    }

    /**
     * Gets query for [[Nurse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNurse()
    {
        return $this->hasOne(Nurse::class, ['id_nurse' => 'nurse_id']);
    }
}
