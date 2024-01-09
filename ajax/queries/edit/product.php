<?php
include('../../../config.php');
include("../../../system_functions.php");

class ProductManager
{
    private $conn;
    private $username;
    private $datetime;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->username = $_SESSION['username'];
        $this->datetime = date('Y-m-d H:i:s');
    }

    public function updateProduct($productName, $quantity, $serialNumber, $reorderLevel, $reorderQuantity, $leadTime, $variations, $sellingPrice, $id_index)
    {
        $updateQuery = "UPDATE dbo.Product 
                        SET productName = ?, quantityOnHand = ?, serialNo = ?, reorderLevel = ?, reorderQuantity = ?, reorderLeadTime = ?, productVariation = ?, unitPrice = ?
                        WHERE productNo = ?";
        $updateParams = array(
            $productName, $quantity, $serialNumber, $reorderLevel, $reorderQuantity, $leadTime, $variations, $sellingPrice, $id_index
        );

        $stmt = sqlsrv_prepare($this->conn, $updateQuery, $updateParams);
        if ($stmt === false) {
            // Handle update prepare statement error
            die(print_r(sqlsrv_errors(), true));
        }

        $updateResult = sqlsrv_execute($stmt);

        if ($updateResult === false) {
            // Handle update error
            die(print_r(sqlsrv_errors(), true));
        }

        $rowsAffected = sqlsrv_rows_affected($stmt);

        if ($rowsAffected === false || $rowsAffected < 1) {
            // No rows affected, potential issue with update
            return 2; // Error occurred while updating the product
        } else {
            $this->logSuccess($productName);
            return 1; // Product updated successfully
        }
    }

    private function logSuccess($productName)
    {
        $mac_address = NetworkDetails::getMacAddress();
        $ip_address = NetworkDetails::getRealIpAddress();
        $query = "INSERT INTO dbo.logs
            (logdate, section, [message], [user], macaddress, ipaddress, action)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array($this->datetime, 'Product', "Added product $productName as product successfully", $this->username, $mac_address, $ip_address, 'Successful');

        $logStmt = sqlsrv_prepare($this->conn, $query, $params);
        if ($logStmt === false) {
            // Handle log prepare statement error
            die(print_r(sqlsrv_errors(), true));
        }

        sqlsrv_execute($logStmt) or die(print_r(sqlsrv_errors(), true));
    }
}

$productManager = new ProductManager($conn);

$result = $productManager->updateProduct(
    $_POST['productname'],
    $_POST['quantity'],
    $_POST['serialnumber'],
    $_POST['reorderlevel'],
    $_POST['reorderquantity'],
    $_POST['leadtime'],
    $_POST['variations'],
    $_POST['sellingprice'],
    $_POST['id_index']
);

echo $result;
