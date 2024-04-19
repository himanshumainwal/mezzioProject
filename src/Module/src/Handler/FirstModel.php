<?php

declare(strict_types=1);

namespace Module\Handler;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Sql;

class FirstModel
{
    private $dbObj;

    public function __construct(AdapterInterface $db)
    {
        $this->dbObj = $db;
    }

    public function getDbObj($queryPrint=false)
    {
        $sql = new Sql($this->dbObj);
        $querySet = $sql->select();

        $querySet->columns([
            "fullName" => "full_name", // Alise name of the Database Coloums,
            "email" => "email",
            "password" => "password",
            "mobileNumber" => "mobile_number"
        ]);

        $querySet->from([
            "TableName" => "mezzio_pro"
        ]);

        $statement = $sql->prepareStatementForSqlObject($querySet);

        if($queryPrint){
            die($sql->buildSqlString($querySet));
        }

        $result = $statement->execute();

        if($result->count()){
            $resultSet = new HydratingResultSet();
            return $resultSet->initialize($result)->toArray();
        }
    }
}
