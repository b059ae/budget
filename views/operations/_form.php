<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Accounts;

/* @var $this yii\web\View */
/* @var $model app\models\Operations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'account_id')->dropDownList(ArrayHelper::map(Accounts::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'sum')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Изменить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
