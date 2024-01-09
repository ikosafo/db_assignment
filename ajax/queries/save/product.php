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
        // Get the last productNo from dbo.Product table
        $getLastProductNoQuery = "SELECT MAX(productNo) AS lastProductNo FROM dbo.Product";
        $getLastProductNoStmt = sqlsrv_query($this->conn, $getLastProductNoQuery);

        if ($getLastProductNoStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($getLastProductNoStmt, SQLSRV_FETCH_ASSOC);
        $lastProductNo = $row['lastProductNo'];

        // Increment the last productNo by 1 to generate a unique product number
        $productNo = $lastProductNo + 1;

        $insertQuery = "INSERT INTO dbo.Product 
                    (productNo, productName, quantityOnHand, serialNo, reorderLevel, reorderQuantity, reorderLeadTime, productVariation, unitPrice)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertParams = array(
            $productNo, $productName, $quantity, $serialNumber, $reorderLevel, $reorderQuantity, $leadTime, $variations, $sellingPrice
        );

        $stmt = sqlsrv_prepare($this->conn, $insertQuery, $insertParams);
        if ($stmt === false) {
            // Handle prepare statement error
            die(print_r(sqlsrv_errors(), true));
        }

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
            //$this->logSuccess($productName);
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
