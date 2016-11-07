<?php

namespace app\models;

use yii\base\Model;

class UserSiteForm extends Model
{
    public $id;
    public $user_id;
    public $service_id;
    public $ip_address;
    public $domain;
    public $is_active;

    /** @var  User $user */
    public $user;

    /** @var  Service $service */
    public $service;

    private $userSiteModel = null;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id',
                    'service_id',
                    'ip_address',
                    'domain',
                    'is_active',
                ], 'required'
            ],
            [
                ['ip_address'],
                'unique',
                'targetClass' => UsersSites::className(),
                'message' => 'The ip address already exists.',
            ],
            [
                ['domain'],
                'unique',
                'targetClass' => UsersSites::className(),
                'message' => 'The domain already exists.',
            ],
            ['ip_address', 'ip'],
            ['domain', 'url'],
            [
                [
                    'user_id',
                    'service_id',
                    'is_active'
                ],
                'integer'
            ],
            [
                [
                    'domain',
                    'ip_address'
                ],
                'trim'
            ]
        ];
    }

    /**
     * @param int $id
     */
    public function fillForm(int $id) : void
    {
        $userSiteModel = UsersSites::findOne(['id' => $id]);
        $this->user = $userSiteModel->user;
        $this->service = $userSiteModel->services;
        $this->id = $userSiteModel->id;
        $this->user_id = $userSiteModel->user_id;
        $this->service_id = $userSiteModel->services->id;
        $this->domain = $userSiteModel->domain;
        $this->is_active = $userSiteModel->is_active;
        $this->ip_address = $userSiteModel->ip_address;
    }

    public function saveNew() : bool
    {
        $newUserSite = new UsersSites();
        $newUserSite->is_active = 1;
        $newUserSite->domain = $this->domain;
        $newUserSite->ip_address = $this->ip_address;
        $newUserSite->user_id = $this->user_id;
        if ($newUserSite->save()) {
            $newUserSiteService = new UsersSitesServices();
            $newUserSiteService->services_id = $this->service_id;
            $newUserSiteService->users_sites_id = $newUserSite->id;
            $this->id = $newUserSite->id;
            if ($newUserSiteService->save()) {
                return true;
            }
        }
        return false;
    }

    public function update(int $id)
    {
        $userSite = UsersSites::findOne(['id' => $id]);
        if (!$userSite) {
            return false;
        }
        $user = $userSite->user;
        $userSiteService = $userSite->usersSitesServices;
        $userSite->domain  = $this->domain;
        $userSite->ip_address  = $this->ip_address;
        $userSite->user_id  = $this->user_id;
        if ($userSiteService) {
            $userSiteService->services_id = $this->service_id;
        }
        return $userSite->save() && $userSiteService->save();
    }


    public function isNewRecord() : bool
    {
        return ! (bool) $this->userSiteModel;
    }
}