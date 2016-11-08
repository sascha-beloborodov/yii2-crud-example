<?php

use app\models\Service;
use app\models\User;
use yii\db\Migration;

class m161107_062743_fill_tables extends Migration
{
    public function up()
    {
        foreach (range(1, 5) as $num) {
            $service = new Service();
            $faker = \Faker\Factory::create();
            $service->type = $faker->company;
            $service->save();
        }

        foreach (range(1, 200) as $num) {
            $faker = \Faker\Factory::create();
            $user = new User();
            $isAdmin = false;
            if ($num < 4) {
                $user->role = User::ADMIN_ROLE;
                $isAdmin = true;
            } else {
                $user->role = User::DEFAULT_ROLE;
            }
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $faker->email;
            $user->username = $faker->userName;
            $user->password = Yii::$app->security->generatePasswordHash('Pa$$w0rd!');
            $user->save();

            if (!$isAdmin) {
                foreach (range(1, 5) as $nestNum) {
                    $userSite = new \app\models\UsersSites();
                    $userSite->domain = $faker->domainName;
                    $userSite->ip_address = $faker->ipv4;
                    $userSite->is_active = 1;
                    $userSite->user_id = $user->id;
                    $userSite->save();
                    $userSiteService = new \app\models\UsersSitesServices();
                    $userSiteService->users_sites_id = $userSite->id;
                    $userSiteService->services_id = $nestNum;
                    $userSiteService->save();
                }
            }
        }
    }

    public function down()
    {
        echo "m161107_062743_fill_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
