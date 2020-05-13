<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property int $notification_password
 * @property int $notification_news
 */
class Users extends \yii\db\ActiveRecord
{
    public $change_password;
    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'on' => 'register'],
            [['change_password', 'password_repeat'], 'safe', 'on' => 'profile'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_repeat'], 'required', 'on' => 'register'],
            ['change_password', 'compare', 'compareAttribute' => 'password_repeat', 'on' => 'profile'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat',  'on' => 'register'],
            [['notification_password', 'notification_news'], 'boolean'],
            [['email'], 'string', 'max' => 150],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'change_password' => 'Изменить пароль',
            'password_repeat' => 'Повторите пароль',
            'notification_password' => 'Уведомление при смене пароля',
            'notification_news' => 'Уведомление при редактировании или удалении новости',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord or (!$this->isNewRecord and !empty($this->change_password))) {
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->isNewRecord ? $this->password : $this->change_password);
            User::generateAuthKey();

            if(!$this->isNewRecord and $this->notification_password) {
                Yii::$app->notifications->send($this, 'Изменение пароля', 'В вашей учетной записи изменился пароль на: '.$this->change_password);
            }
        }

        return parent::beforeSave($insert);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }



}
