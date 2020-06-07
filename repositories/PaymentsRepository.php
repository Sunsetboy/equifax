<?php

namespace app\repositories;

use PDO;
use Yii;
use yii\db\Connection;
use yii\db\DataReader;

/**
 * Encapsulates working with payments data stored in DB
 * Class PaymentsRepository
 */
class PaymentsRepository
{
    /** @var Connection */
    private $dbConnection;

    /**
     * PaymentsRepository constructor.
     * @param Connection $dbConnection
     */
    public function __construct(Connection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * prevent the reader from consuming a lot of memory
     */
    private function preventExtraMemoryUsage():void
    {
        $this->dbConnection->getMasterPdo()
            ->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    }

    /**
     * @return DataReader
     * @throws \yii\db\Exception
     */
    public function getPaymentsWithoutCreditIdsReader(): DataReader
    {
        $query = "SELECT p.id FROM payments p
LEFT JOIN credits c ON p.cred_id = c.id
WHERE c.id IS NULL";
        $this->preventExtraMemoryUsage();

        $readPaymentsCommand = $this->dbConnection->createCommand($query);

        return $readPaymentsCommand->query();
    }

    /**
     * @return DataReader
     * @throws \yii\db\Exception
     */
    public function getOverduePaymentsReader(): DataReader
    {
        $this->preventExtraMemoryUsage();

        $query = 'SELECT p.id, p.data_set, p.cred_id
FROM payments p
LEFT JOIN credits c ON p.cred_id = c.id
where c.id IS NOT NULL';

        $readOverduesCommand = $this->dbConnection->createCommand($query);

        return $readOverduesCommand->query();
    }
}