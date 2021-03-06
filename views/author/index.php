<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Manage authors', ['manage'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'name',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->name), Url::to(['author/view', 'id' => $model->id]));
                }
            ],
            'booksCount',
        ],
    ]); ?>


</div>
