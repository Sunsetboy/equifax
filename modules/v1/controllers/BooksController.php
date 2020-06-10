<?php

namespace app\modules\v1\controllers;

use app\models\Book;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class BooksController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    /**
     * @return array
     */
    public function actionList()
    {
        $books = Book::find()->with('author')->all();

        $booksResponseArray = [];
        foreach ($books as $book) {
            $booksResponseArray[] = [
                'id' => $book->id,
                'title' => Html::encode($book->title),
                'author' => Html::encode($book->author->name),
            ];
        }

        return $booksResponseArray;
    }

    /**
     * @param int $id
     * @return ActiveRecord|null
     */
    public function actionById()
    {
        $id = (int)Yii::$app->request->get('id');

        return Book::find()
            ->where(['id' => $id])
            ->one();
    }
}
