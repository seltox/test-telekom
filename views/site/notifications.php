<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\NotificationsForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Отправка уведомлений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('FormSubmitted')): ?>

        <div class="alert alert-success">
            Уведомления успешно отправлены
        </div>

    <?php else: ?>


        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>



                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

                    <legend>Пользователи</legend>

                    <?php if($model->hasErrors('users')): ?>
                        <div class="alert alert-warning">
                            Укажите хотя бы одного пользователя
                        </div>

                    <?php endif; ?>

                     <?= $form->field($model, 'users[]')->checkboxList(\yii\helpers\ArrayHelper::map($users, 'id', 'email'), [
                                'template' => "<div class=\"col-lg-offset-1 col-lg-1\">{input} </div><div class='col-lg-7'>".$user->email."</div> ",
                            ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'notifications-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
