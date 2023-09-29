<?php

/** @var yii\web\View $this */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Cushon ISA investment application</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?php $form = ActiveForm::begin(); ?>
                    <?php
                    echo $form
                        ->field($investment, 'account_id')
                        ->dropDownList(ArrayHelper::map($accounts, 'id', 'id'));


                    echo $form
                        ->field($investment, 'fund_id')
                        ->dropDownList(ArrayHelper::map($funds, 'id', 'name'));

                    echo $form->field($investment, 'amount');

                    ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>
</div>
