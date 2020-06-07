<?php

namespace app\commands;

use app\repositories\PaymentsRepository;
use app\services\CreditsService;
use app\services\OverduePaymentXMLChecker;
use app\services\PaymentsService;
use Yii;
use yii\console\Controller;

class ExportCreditsController extends Controller
{
    /**
     * Получение списка id платежей, у которых нет кредитов
     */
    public function actionGetPaymentsWithoutCredits()
    {
        echo '=== Exporting payments without credits ===' . PHP_EOL;

        $paymentsService = new PaymentsService(Yii::$app->db);
        $paymentsService->exportPaymentsWithoutCredits(Yii::getAlias('@runtime') . '/payments_without_credits.txt');

        echo 'Memory usage during iteration query: ' .
            memory_get_usage(true) . ' bytes' . PHP_EOL;
    }

    /**
     * Экспорт кредитов с просрочкой
     * @throws \yii\db\Exception
     */
    public function actionExportCreditsWithOverdue()
    {
        $creditsService = new CreditsService(Yii::$app->db);

        $overduesFile = Yii::getAlias('@runtime') . '/overdue.txt';
        $overduesInvalidFile = Yii::getAlias('@runtime') . '/overdue_invalid.txt';

        $creditsService->exportCreditsWithOverdue($overduesFile);

        $overdueXmlChecker = new OverduePaymentXMLChecker();
        $overdueXmlChecker->checkOverduesXmlFile($overduesFile, $overduesInvalidFile);

        echo 'Memory usage: ' .
            memory_get_usage(true) . ' bytes' . PHP_EOL;
    }
}
