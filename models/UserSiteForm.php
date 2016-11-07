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
            [['ip_address'], 'unique'],
            [['domain'], 'unique'],
            ['ip_address', 'ip'],
            ['domain', 'url'],
        ];
    }

    /**
     * @param int $id
     */
    public function fillForm(int $id)
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

    public function saveNew($id = null)
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

    public function isNewRecord()
    {
        return ! (bool) $this->userSiteModel;
    }
}