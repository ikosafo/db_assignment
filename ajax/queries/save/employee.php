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
        // Check if username already exists
        $checkUsernameQuery = "SELECT COUNT(*) AS usernameCount FROM dbo.Employee WHERE username = ?";
        $checkStmt = sqlsrv_prepare($this->conn, $checkUsernameQuery, array($username));
        if ($checkStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $checkResult = sqlsrv_execute($checkStmt);
        if ($checkResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $usernameRow = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
        $usernameCount = $usernameRow['usernameCount'];

        if ($usernameCount > 0) {
            return 3; // Username already exists
        }

        // Encrypt the password
        $encryptedPassword = md5($password);

        // Get the last employeeNo from dbo.Employee table
        $getLastEmployeeNoQuery = "SELECT MAX(employeeNo) AS lastEmployeeNo FROM dbo.Employee";
        $getLastEmployeeNoStmt = sqlsrv_query($this->conn, $getLastEmployeeNoQuery);

        if ($getLastEmployeeNoStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($getLastEmployeeNoStmt, SQLSRV_FETCH_ASSOC);
        $lastEmployeeNo = $row['lastEmployeeNo'];

        // Increment the last employeeNo by 1 to generate a unique employee number
        $employeeNo = $lastEmployeeNo + 1;


        $insertQuery = "INSERT INTO dbo.Employee 
                    (employeeNo, title, firstName, middleName, lastName, address, workTelExt, homeTelNo, empEmailAddress, socialSecurityNumber, DOB, position, sex, salary, dateStarted, username, password)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertParams = array(
            $employeeNo, $title, $firstName, $middleName, $lastName, $address, $workTelExt, $homeTelNo, $empEmailAddress, $socialSecurityNumber, $DOB, $position, $sex, $salary, $dateStarted, $username, $encryptedPassword
        );

        $stmt = sqlsrv_prepare($this->conn, $insertQuery, $insertParams);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $insertResult = sqlsrv_execute($stmt);

        if ($insertResult === false) {
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
