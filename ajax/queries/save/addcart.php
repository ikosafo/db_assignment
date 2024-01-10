<?php
// Include necessary files and define your database connection
include('../../../config.php');
include("../../../system_functions.php");

class ProductManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addToTempOrder($productNo, $quantity, $genNo)
    {
        $checkQuery = "SELECT COUNT(*) AS count FROM dbo.tempOrder WHERE productNo = ? AND genNo = ?";
        $checkParams = array($productNo, $genNo);
        $checkStmt = sqlsrv_query($this->conn, $checkQuery, $checkParams);

        if ($checkStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $checkRow = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
        $count = $checkRow['count'];

        if ($count > 0) {
            $updateQuery = "UPDATE dbo.tempOrder SET quantity = quantity + ? WHERE productNo = ? AND genNo = ?";
            $updateParams = array($quantity, $productNo, $genNo);
            $updateStmt = sqlsrv_prepare($this->conn, $updateQuery, $updateParams);

            if ($updateStmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $updateResult = sqlsrv_execute($updateStmt);

            if ($updateResult === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $rowsAffected = sqlsrv_rows_affected($updateStmt);

            if ($rowsAffected === false || $rowsAffected < 1) {
                return 2; // Error occurred while updating quantity
            } else {
                return "Quantity updated for productNo: " . $productNo . " and genNo: " . $genNo;
            }
        } else {
            $getLastTemSalesNoQuery = "SELECT MAX(temSalesNo) AS lastTemSalesNo FROM dbo.tempOrder";
            $getLastTemSalesNoStmt = sqlsrv_query($this->conn, $getLastTemSalesNoQuery);

            if ($getLastTemSalesNoStmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($getLastTemSalesNoStmt, SQLSRV_FETCH_ASSOC);
            $lastTemSalesNo = $row['lastTemSalesNo'];
            $temSalesNo = $lastTemSalesNo + 1;

            /*  $insertQuery = "INSERT INTO dbo.tempOrder ([temSalesNo], [productNo], [quantity], [genNo]) VALUES (?, ?, ?, ?)";
            $insertParams = array($temSalesNo, $productNo, $quantity, $genNo);
            $insertStmt = sqlsrv_prepare($this->conn, $insertQuery, $insertParams); */

            $insertStoredProcedure = "{call dbo.InsertTempOrder(?, ?, ?, ?)}";
            $insertParams = array($temSalesNo, $productNo, $quantity, $genNo);
            $insertStmt = sqlsrv_prepare($this->conn, $insertStoredProcedure, $insertParams);


            if ($insertStmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $insertResult = sqlsrv_execute($insertStmt);

            if ($insertResult === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $rowsAffected = sqlsrv_rows_affected($insertStmt);

            if ($rowsAffected === false || $rowsAffected < 1) {
                return 3; // Error occurred while adding to tempOrder
            } else {
                return $temSalesNo; // Return the generated temSalesNo
            }
        }
    }
}

$productManager = new ProductManager($conn);

$result = $productManager->addToTempOrder(
    $_POST['productNo'],
    $_POST['quantity'],
    $_POST['getneworderid']
);

echo $result; // Output the generated temSalesNo or error code
