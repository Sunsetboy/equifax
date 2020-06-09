<?php

namespace app\commands;

use app\models\Author;
use app\models\Book;
use Faker\Factory;
use yii\console\Controller;

class SeedDbController extends Controller
{
    /**
     * Seeds the database by fake data
     */
    public function actionIndex()
    {
        $faker = Factory::create('ru_RU');

        for ($a = 0; $a < 10; $a++) {
            $author = new Author();
            $author->name = $faker->name;

            if ($author->save()) {
                for ($b = 0; $b < mt_rand(0, 3); $b++) {
                    $book = new Book();
                    $book->title = $faker->sentence;
                    $book->author_id = $author->id;
                    $book->save();
                }
            }
        }
    }
}