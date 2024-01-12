<?php
include('../../../config.php');
include("../../../system_functions.php");

class ProductManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->username = $_SESSION['username'];
        $this->datetime = date('Y-m-d H:i:s');
    }

    public function addEmployee(
        $title,
        $firstName,
        $middleName,
        $lastName,
        $address,
        $workTelExt,
        $homeTelNo,
        $empEmailAddress,
        $socialSecurityNumber,
        $DOB,
        $position,
        $sex,
        $salary,
        $dateStarted,
        $username,
        $password
    ) {
        // Prepare the SQL query with a parameter placeholder for the stored procedure
        $insertQuery = "{CALL AddEmployee(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
        $insertParams = array(
            array($title, SQLSRV_PARAM_IN),
            array($firstName, SQLSRV_PARAM_IN),
            array($middleName, SQLSRV_PARAM_IN),
            array($lastName, SQLSRV_PARAM_IN),
            array($address, SQLSRV_PARAM_IN),
            array($workTelExt, SQLSRV_PARAM_IN),
            array($homeTelNo, SQLSRV_PARAM_IN),
            array($empEmailAddress, SQLSRV_PARAM_IN),
            array($socialSecurityNumber, SQLSRV_PARAM_IN),
            array($DOB, SQLSRV_PARAM_IN),
            array($position, SQLSRV_PARAM_IN),
            array($sex, SQLSRV_PARAM_IN),
            array($salary, SQLSRV_PARAM_IN),
            array($dateStarted, SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN),
            array($password, SQLSRV_PARAM_IN)
        );

        // Prepare the SQL statement
        $stmt = sqlsrv_prepare($this->conn, $insertQuery, $insertParams);

        if ($stmt === false) {
            // Handle prepare statement error
            die(print_r(sqlsrv_errors(), true));
        }

        // Execute the prepared statement
        $insertResult = sqlsrv_execute($stmt);

        if ($insertResult === false) {
            // Handle insertion error
            die(print_r(sqlsrv_errors(), true));
        }

        $rowsAffected = sqlsrv_rows_affected($stmt);

        if ($rowsAffected === false || $rowsAffected < 1) {
            return 2; // Error occurred while adding the employee
        } else {
            return 1; // Employee added successfully
        }
    }
}

$productManager = new ProductManager($conn);

$result = $productManager->addEmployee(
    $_POST['title'],
    $_POST['firstname'],
    $_POST['middlename'],
    $_POST['lastname'],
    $_POST['address'],
    $_POST['worktelephone'],
    $_POST['hometelephone'],
    $_POST['emailaddress'],
    $_POST['ssnitno'],
    $_POST['dateofbirth'],
    $_POST['position'],
    $_POST['gender'],
    $_POST['salary'],
    $_POST['datestarted'],
    $_POST['username'],
    $_POST['password']
);

echo $result;
