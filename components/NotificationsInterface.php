<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 13.05.2020
 * Time: 12:46
 */

namespace app\components;


interface NotificationsInterface
{
    /**
     * @param $options array
     * @return mixed
     */
    public function init($options);

    /**
     * @param $users object | array
     * @return mixed
     */
    public function setUsers($users);

    /**
     * @param $notification string
     * @return mixed
     */
    public function sendNotification($subject, $notification);

}