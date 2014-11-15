<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Apis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apis-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'placeholder' => 'Graph API']) ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => 255, 'placeholder' => 'The best API in the world!']) ?>

	<?= $form->field($model, 'version')->textInput(['maxlength' => 255, 'placeholder' => '1.0']) ?>

	<?php // $form->field($model, 'objects')->textInput() ?>

	<?php // $form->field($model, 'created_by')->textInput() ?>

	<?php // $form->field($model, 'updated_by')->textInput() ?>

	<?php // $form->field($model, 'likes')->textInput() ?>

	<?php // $form->field($model, 'dislikes')->textInput() ?>

	<?php // $form->field($model, 'created_at')->textInput() ?>

	<?php // $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
