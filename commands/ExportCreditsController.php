<?php

namespace app\commands;

use app\repositories\PaymentsRepository;
use Yii;
use yii\console\Controller;

class ExportCreditsController extends Controller
{
    /**
     * Получение списка id платежей, у которых нет кредитов
     */
    public function actionGetPaymentsWithoutCredits()
    {
        $paymentFile = Yii::getAlias('@runtime') . '/payments_without_credits.txt';
        file_put_contents($paymentFile, '');

        echo '=== Exporting payments without credits ===' . PHP_EOL;

        // @todo change an object creation to DI
        $dataReader = (new PaymentsRepository)->getPaymentsWithoutCreditIdsReader();

        while ($row = $dataReader->read()) {
            $paymentId = $row['id'];
            file_put_contents($paymentFile, $paymentId . PHP_EOL, FILE_APPEND);
        }

        echo 'Memory usage during iteration query: ' .
            memory_get_usage(true) . ' bytes' . PHP_EOL;
    }
}
