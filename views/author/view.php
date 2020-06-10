<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Author */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php if (sizeof($model->books) > 0): ?>
        <h2>Books</h2>
        <ul>
            <?php foreach ($model->books as $book): ?>
                <li><?php echo Html::a(Html::encode($book->title), Url::to(['book/view', 'id' => $book->id])); ?></li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p>We don't have information about books of this author</p>
    <?php endif; ?>

</div>
