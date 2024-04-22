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

    public function getDbObj($queryPrint = false)
    {
        $sql = new Sql($this->dbObj);
        $querySet = $sql->select();

        $querySet->columns([
            "fullName" => "full_name", // Alias name of the Database Coloums,
            "email" => "email",
            "password" => "password",
            "mobileNumber" => "mobile_number"
        ]);

        $querySet->from([
            "TableName" => "mezzio_pro" // Alias name of the Database Table Name,
        ]);

        // $querySet->where->nest() // Show all data for this table
        //     ->equalTo('email','himanshu@gmail.com')
        //     ->unnest();

        $statement = $sql->prepareStatementForSqlObject($querySet);

        if ($queryPrint) {
            die($sql->buildSqlString($querySet));
        }

        $result = $statement->execute();

        if ($result->count()) {
            $resultSet = new HydratingResultSet();
            return $resultSet->initialize($result)->toArray();
        }
    }

    public function addUser($name,  $email,  $password,  $mobileNumber)
    {
        $insert = new Sql($this->dbObj);
        $insertStatement = $insert->insert('mezzio_pro');
        $insertStatement->values([
            'full_name' => $name,
            'email' => $email,
            'password' => $password,
            'mobile_number' => $mobileNumber,
        ]);

        $statement = $insert->prepareStatementForSqlObject($insertStatement);
        $result = $statement->execute();

        return $result->getAffectedRows() > 0;
    }


    public function verifiedUser($email, $password)
    {
        // Construct the SQL query to fetch the user record based on the provided email
        $sql = new Sql($this->dbObj);
        $select = $sql->select('mezzio_pro');
        // Add a WHERE condition to filter by email
        $select->where(['email' => $email, 'password' => $password]);

        // Prepare the SQL statement and execute it
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        // Fetch the user record
        $user = $result->current();
        // Check if a user with the provided email exists and if the password matches
        if ($email == $user['email'] && $password == $user['password']) {
            // Password matches, return the user object
            // print_r($user);die;
            return $user;
        }

        // No user found or password does not match, return null
        return null;
    }

    public function redirectPage($msg, $path)
    {
        return $content = '
        <script>
            alert("'.$msg.'");
            window.location.href = "/' . $path . '"; // Redirect to the register page
        </script>
    ';
        // Return the HTML response with the script tag and redirection
    }
}
