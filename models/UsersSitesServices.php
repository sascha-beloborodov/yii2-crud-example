<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_sites_services".
 *
 * @property integer $users_sites_id
 * @property integer $services_id
 *
 * @property Service $services
 * @property UsersSites $usersSites
 */
class UsersSitesServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_sites_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_sites_id', 'services_id'], 'required'],
            [['users_sites_id', 'services_id'], 'integer'],
            [['services_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['services_id' => 'id']],
            [['users_sites_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersSites::className(), 'targetAttribute' => ['users_sites_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'users_sites_id' => 'Users Sites ID',
            'services_id' => 'Services ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Service::className(), ['id' => 'services_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSites()
    {
        return $this->hasOne(UsersSites::className(), ['id' => 'users_sites_id']);
    }
}
