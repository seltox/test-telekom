<?php

namespace app\models;

use Yii;
use yii\base\Model;


class NotificationsForm extends Model
{
    public $users;
    public $subject;
    public $text;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['subject', 'text', 'users'], 'required'],
            ['users', 'checkCountUsers'],

        ];
    }

    public function checkCountUsers ($attribute, $params) {
        $this->users = array_filter(array_map('intval', $this->users));
        if(!count($this->users)) {
            $this->addError('users', 'error_count');
        }
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'subject' => 'Тема уведомления',
            'text' => 'Текст уведомления',
            'users' => 'Пользователи'
        ];
    }


}
