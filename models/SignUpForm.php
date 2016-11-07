<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class SignUpForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_repeat;
    public $username;

    public function rules()
    {
        return [
            [
                [
                    'password',
                    'password_repeat',
                    'first_name',
                    'last_name',
                    'email',
                    'username'
                ], 'required'
            ],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => 'User already exists',
                // 'filter' => function (Query $query) {
                //     $query->andWhere(['!=', 'status', UserModel::STATUS_DELETE]);
                //     $query->andWhere(['!=', 'id', $this->id]);
                // }
            ],
            [
                'username',
                'unique',
                'targetClass' => User::className(),
                'message' => 'User already exists',
                // 'filter' => function (Query $query) {
                //     $query->andWhere(['!=', 'status', UserModel::STATUS_DELETE]);
                //     $query->andWhere(['!=', 'id', $this->id]);
                // }
            ],
            ['password', 'string', 'min' => 6, 'max' => 28],
            ['email', 'email'],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => "The password does not match.",
            ],
        ];
    }


    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'password' => 'Password',
            'password_repeat' => 'Repeat password',
            'username' => 'Username',
            'email' => 'Email',

        ];
    }

    public function save()
    {
        $user = new User();
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->role = User::DEFAULT_ROLE;
        return $user->save();
    }

}
