<?php

namespace app\repositories;

use PDO;
use Yii;
use yii\db\DataReader;

/**
 * Encapsulates working with payments data stored in DB
 * Class PaymentsRepository
 */
class PaymentsRepository
{
    public function getPaymentsWithoutCreditIdsReader(): DataReader
    {
        $query = "SELECT p.id FROM payments p
LEFT JOIN credits c ON p.cred_id = c.id
WHERE c.id IS NULL";

        $readPaymentsCommand = Yii::$app->db->createCommand($query);

        // prevent the reader from consuming a lot of memory
        Yii::$app->db->getMasterPdo()
            ->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        return $readPaymentsCommand->query();
    }
}