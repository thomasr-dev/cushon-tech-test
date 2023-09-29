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
                Thank you for your investment of £<?= number_format($investment->amount, 2)?>.
            </div>

        </div>

    </div>
</div>
