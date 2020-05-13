<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 13.05.2020
 * Time: 12:44
 */
namespace app\components;

class Email implements NotificationsInterface
{

    protected $_users = array();
    protected $_options = array();

    public function init($options) {
        $this->_options = $options;
    }

    public function setUsers($users)
    {
        $this->_users = is_array($users) ? $users : array($users);
    }

    public function sendNotification($subject, $notification)
    {
        foreach($this->_users as $user) {
            \Yii::$app->mailer->compose()
                ->setFrom($this->_options['fromEmail'])
                ->setTo($user->email)
                ->setSubject($subject)
                ->setHtmlBody($notification)
                ->send();
        }
    }
}