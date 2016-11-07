<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "users_sites".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $domain
 * @property string $ip_address
 * @property integer $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property UsersSitesServices[] $usersSitesServices
 * @property Service[] $services
 */
class UsersSites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'domain', 'ip_address'], 'required'],
            [['user_id', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['domain', 'ip_address'], 'string', 'max' => 255],
            [['domain'], 'unique'],
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
            'domain' => 'Domain',
            'ip_address' => 'Ip Address',
            'is_active' => 'Is Active',
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
    public function getUser()
    {
        return $this
            ->hasOne(User::className(), ['id' => 'user_id'])
            ->where(['<>', 'role', User::ADMIN_ROLE]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Service::className(), ['id' => 'services_id'])
            ->viaTable('users_sites_services', ['users_sites_id' => 'id']);
    }

    public static function getList(int $limit, int $page) : array
    {
        $result = self::find()
            ->with('user')
            ->with('services')
            ->limit(10)
            ->orderBy('id')
            ->all();

        return self::getPreparedList($result);
    }

    private static function getPreparedList(array $list) : array
    {
        $result = [];
        $currentUser = null;
        $cnt = count($list);
        $i = 0;
        $userCounter = -1;

        do {
            if (0 === $cnt) {
                break;
            }
            if ($currentUser !== (int) $list[$i]->user->id) {
                $userCounter++;
                $result[$userCounter]['user'] = $list[$i]->user;
            }
            $result[$userCounter]['sites'][$i] = $list[$i]->toArray();
            $result[$userCounter]['sites'][$i]['services'] = [];
            $result[$userCounter]['sites'][$i]['services'][] = $list[$i]->services->toArray();
            $currentUser = (int) $list[$i]->user->id;
            $i++;
        } while($i < $cnt);

        return $result;
    }
}
