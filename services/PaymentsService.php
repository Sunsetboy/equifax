<?php


namespace app\services;


use app\repositories\PaymentsRepository;
use Yii;
use yii\db\Connection;

class PaymentsService
{
    private $dbConnection;

    public function __construct(Connection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function exportPaymentsWithoutCredits(string $outputFile)
    {
        $paymentFile = $outputFile;
        file_put_contents($paymentFile, '');

        // @todo change an object creation to DI
        $dataReader = (new PaymentsRepository($this->dbConnection))->getPaymentsWithoutCreditIdsReader();

        while ($row = $dataReader->read()) {
            $paymentId = $row['id'];
            file_put_contents($paymentFile, $paymentId . PHP_EOL, FILE_APPEND);
        }
    }
}