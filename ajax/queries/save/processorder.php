<?php
include('../../../config.php');
include("../../../system_functions.php");

class ProductManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function updateOrderStatus($genNo)
    {
        // Prepare and execute the SQL update statement
        $updateQuery = "UPDATE dbo.tempOrder SET status = ? WHERE genNo = ?";
        $updateParams = array('1', $genNo);

        $stmt = sqlsrv_prepare($this->conn, $updateQuery, $updateParams);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $updateResult = sqlsrv_execute($stmt);

        if ($updateResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $rowsAffected = sqlsrv_rows_affected($stmt);

        if ($rowsAffected === false || $rowsAffected < 1) {
            return 0; // Error occurred while updating the status
        } else {
            return 1; // Status updated successfully
        }
    }

    public function insertCustomerAndOrder($genNo)
    {
        // Retrieve customer information
        $customerQuery = "SELECT * FROM dbo.Customer WHERE genNo = ?";
        $customerParams = array($genNo);

        $customerStmt = sqlsrv_query($this->conn, $customerQuery, $customerParams);
        if ($customerStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $customerData = sqlsrv_fetch_array($customerStmt, SQLSRV_FETCH_ASSOC);

        // Get the last order number
        $getLastOrderNoQuery = "SELECT MAX(orderNo) AS lastOrderNo FROM dbo.[Order]";
        $getLastOrderNoStmt = sqlsrv_query($this->conn, $getLastOrderNoQuery);
        $lastOrderNo = sqlsrv_fetch_array($getLastOrderNoStmt, SQLSRV_FETCH_ASSOC)['lastOrderNo'];

        // Increment the last order number by 1
        $newOrderNo = $lastOrderNo + 1;

        // Insert into the corresponding Order table
        $orderQuery = "INSERT INTO dbo.[Order]
                ([orderNo], [orderDate], [billingStreet], [billingCity], [billingState], [billingZipCode], [customerNo], [genNo])
                VALUES (?, GETDATE(), ?, ?, ?, ?, ?, ?)";

        // Adjust the column names based on your actual database structure
        $orderParams = array(
            $newOrderNo,
            $customerData['customerStreet'],
            $customerData['customerCity'],
            $customerData['customerState'],
            $customerData['customerZipCode'],
            $customerData['customerNo'],
            $genNo
        );

        $orderStmt = sqlsrv_query($this->conn, $orderQuery, $orderParams);

        if ($orderStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        return 1; // Customer and Order inserted successfully
    }
}

$productManager = new ProductManager($conn);

// Example usage
$genNo = $_POST['id_index'];
$resultUpdate = $productManager->updateOrderStatus($genNo);
$resultInsert = $productManager->insertCustomerAndOrder($genNo);

// Output the results (you may modify this based on your needs)
echo "Update Result: " . $resultUpdate . "<br>";
echo "Insert Result: " . $resultInsert;
