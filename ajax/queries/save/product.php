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

    public function addProduct($productName, $quantity, $serialNumber, $reorderLevel, $reorderQuantity, $leadTime, $variations, $sellingPrice)
    {
        // Prepare the SQL query with a parameter placeholder for the stored procedure
        $insertQuery = "{CALL AddProduct(?, ?, ?, ?, ?, ?, ?, ?)}";
        $insertParams = array(
            array($productName, SQLSRV_PARAM_IN),
            array($quantity, SQLSRV_PARAM_IN),
            array($serialNumber, SQLSRV_PARAM_IN),
            array($reorderLevel, SQLSRV_PARAM_IN),
            array($reorderQuantity, SQLSRV_PARAM_IN),
            array($leadTime, SQLSRV_PARAM_IN),
            array($variations, SQLSRV_PARAM_IN),
            array($sellingPrice, SQLSRV_PARAM_IN)
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
            // No rows affected, potential issue with insertion
            return 2; // Error occurred while adding the product
        } else {
            return 1; // Product added successfully
        }
    }
}

$productManager = new ProductManager($conn);

$result = $productManager->addProduct(
    $_POST['productname'],
    $_POST['quantity'],
    $_POST['serialnumber'],
    $_POST['reorderlevel'],
    $_POST['reorderquantity'],
    $_POST['leadtime'],
    $_POST['variations'],
    $_POST['sellingprice']
);

echo $result;
