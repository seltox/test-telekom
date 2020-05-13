<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 13.05.2020
 * Time: 12:42
 */

namespace app\components;

use yii\base\Component;


class Notifications extends Component
{

    public $providers = array();

    /**
     * @param $user object|array
     */
    public function send($users, $subject, $notification) {
        if(count($this->providers)) {
            foreach($this->providers as $provider) {
                $class = new $provider['class'];
                $class->init($provider['options']);

                $class->setUsers($users);
                $class->sendNotification($subject, $notification);

            }
        }
    }

}