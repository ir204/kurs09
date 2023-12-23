<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "par".
 *
 * @property int $id_parent
 * @property string $fio
 * @property string|null $passport
 * @property string|null $phone
 *
 * @property Child[] $children
 */
class Par extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'par';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 64],
            [['passport'], 'string', 'max' => 16],
            [['phone'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_parent' => 'Id Parent',
            'fio' => 'Fio',
            'passport' => 'Passport',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Child::class, ['parent_id' => 'id_parent']);
    }
}
