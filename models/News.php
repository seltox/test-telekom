<?php

namespace app\models;

use app\components\Notifications;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $anons
 * @property string $text
 * @property string $date
 * @property int $user_id
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'anons', 'text'], 'required'],
            [['anons', 'text'], 'string'],
            [['date'], 'safe'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'anons' => 'Анонс',
            'text' => 'Текст',
            'date' => 'Дата',
            'user_id' => 'Пользователь',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord) {
            $this->user_id = Yii::$app->user->id;
        }

        if(!$this->isNewRecord) {
            $currentUser = Users::findOne($this->user_id);

            if ($currentUser and $currentUser->notification_news) {
                Yii::$app->notifications->send($currentUser, 'Изменение новости', 'Была изменена новость ' . $this->title);
            }
        }

        return parent::beforeSave($insert);
    }
    public function afterDelete()
    {
        parent::afterDelete();

        $currentUser = Users::findOne($this->user_id);

        if ($currentUser and $currentUser->notification_news) {
            Yii::$app->notifications->send($currentUser, 'Удаление новости', 'Была удалена новость ' . $this->title);
        }
    }

    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
