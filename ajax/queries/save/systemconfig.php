<?php
include("../../../config.php");
include("../../../system_functions.php");

class SystemConfiguration
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveSystemConfig()
    {
        // Retrieve POST data
        $companyname = $_POST['companyname'];
        $tagline = $_POST['tagline'];
        $telephone = $_POST['telephone'];
        $whatsapp = $_POST['whatsapp'];
        $emailaddress = $_POST['emailaddress'];
        $currency = 'GHS';
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $terms = $_POST['terms'];
        $sysconid = $_POST['sysconid'];

        // Execute stored procedure
        $insertSystemConfig = "{CALL SaveSystemConfig(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";

        $params = array(
            array($companyname, SQLSRV_PARAM_IN),
            array($tagline, SQLSRV_PARAM_IN),
            array($address, SQLSRV_PARAM_IN),
            array($telephone, SQLSRV_PARAM_IN),
            array($whatsapp, SQLSRV_PARAM_IN),
            array($emailaddress, SQLSRV_PARAM_IN),
            array($currency, SQLSRV_PARAM_IN),
            array($terms, SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN),
            array($password, SQLSRV_PARAM_IN),
            array($sysconid, SQLSRV_PARAM_IN)
        );

        $stmt = sqlsrv_query($this->conn, $insertSystemConfig, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Output success message
        echo 1;
    }
}

// Usage
$systemConfig = new SystemConfiguration($conn);
$systemConfig->saveSystemConfig();
