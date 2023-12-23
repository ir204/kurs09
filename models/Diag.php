<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diag".
 *
 * @property int $id_diag
 * @property string|null $diag
 * @property string|null $date_diag
 * @property string|null $recommends
 * @property int $anamn_id
 *
 * @property Anam $anamn
 */
class Diag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_diag'], 'safe'],
            [['anamn_id'], 'required'],
            [['anamn_id'], 'integer'],
            [['diag'], 'string', 'max' => 128],
            [['recommends'], 'string', 'max' => 256],
            [['anamn_id'], 'exist', 'skipOnError' => true, 'targetClass' => Anam::class, 'targetAttribute' => ['anamn_id' => 'id_anamn']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_diag' => 'Id Diag',
            'diag' => 'Diag',
            'date_diag' => 'Date Diag',
            'recommends' => 'Recommends',
            'anamn_id' => 'Anamn ID',
        ];
    }

    /**
     * Gets query for [[Anamn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnamn()
    {
        return $this->hasOne(Anam::class, ['id_anamn' => 'anamn_id']);
    }
}
