<?php
include('../../../config.php');
include("../../../system_functions.php");


class OrderManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Method to add customer details
    public function addCustomerDetails(
        $customerName,
        $customerStreet,
        $customerCity,
        $customerState,
        $customerZipCode,
        $custTelNo,
        $custFaxNo,
        $customerDOB,
        $customerMaritalStatus,
        $newOrderID,
        $total
    ) {

        // Get the last customerNo from dbo.Customer table
        $getLastCustomerNoQuery = "SELECT MAX(customerNo) AS lastCustomerNo FROM dbo.Customer";
        $getLastCustomerNoStmt = sqlsrv_query($this->conn, $getLastCustomerNoQuery);

        if ($getLastCustomerNoStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($getLastCustomerNoStmt, SQLSRV_FETCH_ASSOC);
        $lastCustomerNo = $row['lastCustomerNo'];

        // Increment the last customerNo by 1 to generate a unique customer number
        $customerNo = $lastCustomerNo + 1;


        // Insert into dbo.Customer table
        $insertCustomerQuery = "INSERT INTO dbo.Customer
            ([customerNo]
            ,[customerName]
            ,[customerStreet]
            ,[customerCity]
            ,[customerState]
            ,[customerZipCode]
            ,[custTelNo]
            ,[custFaxNo]
            ,[DOB]
            ,[maritalStatus]
            ,[genNo]
            ,[creditRating])
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

        $insertCustomerParams = array(
            $customerNo,
            $customerName,
            $customerStreet,
            $customerCity,
            $customerState,
            $customerZipCode,
            $custTelNo,
            $custFaxNo,
            $customerDOB,
            $customerMaritalStatus,
            $newOrderID,
            0 // Assuming default credit rating here, update as necessary
        );

        $stmt = sqlsrv_prepare($this->conn, $insertCustomerQuery, $insertCustomerParams);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $insertResult = sqlsrv_execute($stmt);
        if ($insertResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Get the last pMethodNo from dbo.PaymentMethod table
        $getLastPMethodNoQuery = "SELECT MAX(pMethodNo) AS lastPMethodNo FROM dbo.PaymentMethod";
        $getLastPMethodNoStmt = sqlsrv_query($this->conn, $getLastPMethodNoQuery);

        if ($getLastPMethodNoStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($getLastPMethodNoStmt, SQLSRV_FETCH_ASSOC);
        $lastPMethodNo = $row['lastPMethodNo'];

        // Increment the last pMethodNo by 1 to generate a unique payment method number
        $pMethodNo = $lastPMethodNo + 1;


        // Insert into dbo.PaymentMethod table
        $paymentMethod = $_POST['payment_method']; // Assuming the payment method is received from the form
        $insertPaymentMethodQuery = "INSERT INTO dbo.PaymentMethod
            ([pMethodNo]
            ,[genNo]
            ,[paymentMethod])
            VALUES (?, ?,?)";

        $insertPaymentMethodParams = array(
            $pMethodNo, // Assuming this is related to the new order ID
            $newOrderID,
            $paymentMethod
        );

        $stmtPayment = sqlsrv_prepare($this->conn, $insertPaymentMethodQuery, $insertPaymentMethodParams);
        if ($stmtPayment === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $insertPaymentResult = sqlsrv_execute($stmtPayment);
        if ($insertPaymentResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        return $customerNo; // Return the generated customerNo
    }
}

$orderManager = new OrderManager($conn);

// Process the form data and call addCustomerDetails method with POST values
$customerNo = $orderManager->addCustomerDetails(
    $_POST['customername'],
    $_POST['customerstreet'],
    $_POST['customercity'],
    $_POST['customerstate'],
    $_POST['customerzipcode'],
    $_POST['custtelno'],
    $_POST['custfaxno'],
    $_POST['customerdob'],
    $_POST['customermaritalstatus'],
    $_POST['neworderid'],
    $_POST['total']
);

echo $customerNo; // Output the generated customerNo or error code
