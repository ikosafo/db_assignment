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
        $updateQuery = "UPDATE [companyOrders].[dbo].[tempOrder] SET status = ? WHERE genNo = ?";
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
}

$productManager = new ProductManager($conn);

$result = $productManager->updateOrderStatus($_POST['id_index']);

echo $result;
