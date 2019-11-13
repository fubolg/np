<?php
namespace App\Model;


class Model
{
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function insertAnalytics($analytics)
    {
        $microtimeStart = microtime(true);

        $query = "INSERT INTO `analytics` (ip, result, durationTime, leftOperand, rightOperand) VALUES (INET_ATON(" . $this->connection->quote($analytics['ip']) . "), "
            . $this->connection->quote($analytics['result'])  . ", unix_timestamp(now(6)) - " . $microtimeStart . ", "
            . $this->connection->quote($analytics['leftOperand']->format(self::MYSQL_DATE_FORMAT)) .", "
            . $this->connection->quote($analytics['rightOperand']->format(self::MYSQL_DATE_FORMAT)) .");";

        $this->connection->prepare($query)->execute();
    }
}