<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property string $type
 * @property double $worth
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UsersSitesServices[] $usersSitesServices
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['worth'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 250],
            [['type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'worth' => 'Worth',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSitesServices()
    {
        return $this->hasMany(UsersSitesServices::className(), ['services_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSites()
    {
        return $this->hasMany(UsersSites::className(), ['id' => 'users_sites_id'])
            ->viaTable('users_sites_services', ['services_id' => 'id']);
    }
}
