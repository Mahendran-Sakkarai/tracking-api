<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tracker".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $latitude
 * @property string $longitude
 * @property string $client_id
 * @property integer $created_at
 *
 * @property User $user
 */
class Tracker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tracker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at'], 'required'],
            [['latitude', 'longitude', 'client_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'client_id' => 'Client ID',
            'created_at' => 'Created At'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
