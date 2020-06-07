<?php


namespace app\services;


use app\repositories\PaymentsRepository;
use Yii;
use yii\db\Connection;

class CreditsService
{
    private $dbConnection;

    public function __construct(Connection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @param string $overduesFile
     * @throws \yii\db\Exception
     */
    public function exportCreditsWithOverdue(string $overduesFile): void
    {
        $xmlHead = '<?xml version="1.0" encoding="UTF-8"?>
<payments>' . PHP_EOL;
        $xmlTail = '</payments>';

        file_put_contents($overduesFile, $xmlHead);

        $overduePaymentReader = (new PaymentsRepository($this->dbConnection))->getOverduePaymentsReader();

        while ($row = $overduePaymentReader->read()) {
            if ($row['data_set']) {
                $dataSet = unserialize($row['data_set']);
                if (is_array($dataSet) && isset($dataSet['overdue']) && (int)$dataSet['overdue'] > 0) {

                    $overdueRecord = '<payment id="' . $row['id'] . '">
                        <cred_id>' . $row['cred_id'] . '</cred_id>
                        <overdue>' . (int)$dataSet['overdue'] . '</overdue>
                    </payment>' . PHP_EOL;
                    file_put_contents($overduesFile, $overdueRecord, FILE_APPEND);
                }
            }
        }

        file_put_contents($overduesFile, $xmlTail, FILE_APPEND);
    }
}